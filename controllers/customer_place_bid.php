<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 	Antoine Benevaut
 * @website	www.oursITshow.org
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class Customer_Place_bid extends Public_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('bid_m');
    $this->load->library('form_validation');

    $this->template
      ->append_metadata(css('store.css', 'store'))
      ->append_metadata(js('store.js', 'store'));
  }

  public function index()
  {
    $this->template
      ->build('customer/index', $this->data);
  }

  public function create($module = 'home', $id = 0)
  {
    // Set the comment data
    $comment = $_POST;

    // Logged in? in which case, we already know their name and email
    if ($this->ion_auth->logged_in())
      {
	$comment['user_id']	= $this->current_user->id;
	$comment['name']	= $this->current_user->display_name;
	$comment['email']	= $this->current_user->email;
	$comment['website']	= $this->current_user->website;
      }
    else
      {
	$this->validation_rules[0]['rules'] .= '|required';
	$this->validation_rules[1]['rules'] .= '|required';
      }

    // Set the validation rules
    $this->form_validation->set_rules($this->validation_rules);

    $comment['module']		= $module;
    $comment['module_id']	= $id;
    $comment['is_active']	= (bool) ((isset($this->current_user->group) && $this->current_user->group == 'admin') OR ! $this->settings->moderate_comments);

    // Validate the results
    if ($this->form_validation->run())
      {
	// ALLOW ZEH COMMENTS!? >:D
	$result = $this->_allow_comment();
			
	foreach ($comment as &$data)
	  {
	    // remove {pyro} tags and html
	    $data = escape_tags($data);
	  }

	// Run Akismet or the crazy CSS bot checker
	if ($result['status'] == FALSE)
	  {
	    $this->session->set_flashdata('comment', $comment);
	    $this->session->set_flashdata('error', $result['message']);
	  }
	else
	  {
	    // Save the comment
	    if ($comment_id = $this->comments_m->insert($comment))
	      {
		// Approve the comment straight away
		if ( ! $this->settings->moderate_comments OR (isset($this->current_user->group) && $this->current_user->group == 'admin'))
		  {
		    $this->session->set_flashdata('success', lang('comments.add_success'));
						
		    // add an event so third-party devs can hook on
		    Events::trigger('comment_approved', $comment);
		  }

		// Do we need to approve the comment?
		else
		  {
		    $this->session->set_flashdata('success', lang('comments.add_approve'));
		  }

		$comment['comment_id'] = $comment_id;
					
		// if markdown is allowed we'll parse the body for the email
		if (Settings::get('comment_markdown'))
		  {
		    $comment['comment'] = parse_markdown($comment['comment']);
		  }

		//send the notification email
		$this->_send_email($comment);
	      }

	    // Failed to add the comment
	    else
	      {
		$this->session->set_flashdata('error', lang('comments.add_error'));
	      }
	  }
      }

    // MEINE FREUHER, ZEH VALIDATION HAZ FAILED. BACK TO ZEH BUNKERZ!!!
    else
      {
	$this->session->set_flashdata('error', validation_errors());

	// Loop through each rule
	foreach ($this->validation_rules as $rule)
	  {
	    if ($this->input->post($rule['field']) !== FALSE)
	      {
		$comment[$rule['field']] = escape_tags($this->input->post($rule['field']));
	      }
	  }
	$this->session->set_flashdata('comment', $comment);
      }

    // If for some reason the post variable doesnt exist, just send to module main page
    $redirect_to = $this->input->post('redirect_to') ? $this->input->post('redirect_to') : $module;

    if ($redirect_to == 'pages')
      {
	$redirect_to = 'home';
      }

    redirect($redirect_to);
  }

  private function _send_email($comment = array())
  {
    $this->load->library('email');
    $this->load->library('user_agent');

    // Add in some extra details
    $comment['slug']			= 'comments';
    $comment['sender_agent']	= $this->agent->browser() . ' ' . $this->agent->version();
    $comment['sender_ip']		= $this->input->ip_address();
    $comment['sender_os']		= $this->agent->platform();
    $comment['redirect_url']	= anchor(ltrim($comment['redirect_to'], '/') . '#' . $comment['comment_id']);
    $comment['reply-to']		= $comment['email'];

    //trigger the event
    return (bool) Events::trigger('email', $comment);
  }
}
/* End of file customer_place_bid.php */