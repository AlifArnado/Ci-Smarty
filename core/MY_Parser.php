<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Parser extends CI_Parser {

    protected $ci;
    
    public function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->load->library('smarty');   
    }
    
    /**
    * Parse a template using Smarty. Hows this for a Codeigniter
    * core extension? Nice and simple.
    * 
    * @param mixed $template
    * @param array $data
    * @param mixed $return
    */
    public function parse($template, $data, $return = FALSE)
    {
        // Make sure we have a template, yo.
        if ($template == '')
        {
            return FALSE;
        }
        
        // If no file extension dot has been found default to .tpl for view extensions
        if ( !stripos($template, '.') ) 
        {
            $template = $template.".tpl";
        }
        
        // Merge in any cached variables with our supplied variables
        $data = array_merge($data, $this->ci->load->ci_cached_vars);
        
        // If we have variables to assign, lets assign them
        if ($data)
        {
            $this->ci->smarty->_assign_variables($data);
        }
        
        // Get our template data as a string
        $template_string = $this->ci->smarty->fetch($template);
        
        // If we're returning the templates contents, we're displaying the template
        if ($return == FALSE)
        {
            $this->ci->output->append_output($template_string);
        }
        
        // We're returning the contents, fo'' shizzle
        return $template_string;
    }

}