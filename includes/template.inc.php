<?php
class Template
{
        // general variables for holding HTML and file names
        var $file_string;
        var $root_dir;
        var $other_names;
        var $final;

        // this array contains the global variables for use in the templates
        // it's put up here for easy modification.
        var $global_vars = array();

        /***
          All this function does is set the root directory to the default
          unless another is specified, then it also puts the current template
          into the path.
        **/
        function Template($root = './templates/')
        {
                global $config;

                $this->root_dir = $root . $config['template'] . '/';
        }

        /***
          This will set all the internal file names to be parsed, the only
          required ones are header and footer, the others are optional. Everything
          is parsed in the order it's passed so in

          array(
          'body' => '1.tpl',
          'other' => '2.tpl');

          "body" would be parsed first since it comes before other in the array.
        **/
        function set_files($files = array())
        {
                //
                // set the header/footer first since those are required,
                // we'll use the default unless the script specifies otherwise
                //
                if(isset($files['header']))
                {
                        // there is a specified header
                        if($files['header'] != '')
                        {
                                $this->file_string = file_get_contents($this->root_dir . $files['header']);
                        }
                }
                else
                {
                        $this->file_string = file_get_contents($this->root_dir . 'overall_header.tpl');
                }

                // now handle the other file names
                foreach($files as $name => $file)
                {
                        if($name != 'header' && $name != 'footer')
                        {
                                if(file_exists($this->root_dir . $file))
                                {
                                        $this->file_string .= file_get_contents($this->root_dir . $file);
                                }
                                else
                                {
                                        $this->file_string .= $file;
                                }
                        }
                }

                // to keep order normal we'll put the footer last
                if(isset($files['footer']))
                {
                        if($files['footer'] != '')
                        {
                                $this->file_string .= file_get_contents($this->root_dir . $files['footer']);
                        }
                }
                else
                {
                        $this->file_string .= file_get_contents($this->root_dir . 'overall_footer.tpl');
                }

                // done
                return true;
        }

        /***
          This simply allows the script to replace variables in the individual
          files before they're completely parsed.
        **/
        function assign_vars($tags = array())
        {
                foreach($tags as $tag => $replace)
                {
                        $this->file_string = str_replace('{' . $tag . '}', $replace, $this->file_string);
                }

                return true;
        }

        /***
          This will create the final page by putting all the templates together
          then parsing through all the global variables (defined at the beginning
          of the class).
        **/
        function ppage()
        {
                global $lang;

                $this->final = $this->file_string;

                // now parse through the global variables
                foreach($this->global_vars as $name => $value)
                {
                        $this->final = str_replace('{' . $name . '}', $value, $this->final);
                }

                // now lets parse through language variables that are in the template
                $pattern = "{L_[a-z_A-Z0-9]*}";

                while(preg_match($pattern, $this->final, $langvar))
                {
                        $langvar = $langvar[0];

                        // trim off the first 2 characters cause they'll be the
                        // prefix (L_)...
                        $langvar = substr($langvar, 2);

                        if(isset($parsed[$langvar]))
                        {
                                // its already been parsed through once so
                                // just skip over it
                                continue;
                        }

                        // now we'll make sure the variable exists
                        if(!isset($lang[$langvar]))
                        {
                              die("No such language variable: $langvar");
                        }

                        // now lets replace it!
                        $this->final = str_replace("{L_$langvar}", $lang[$langvar], $this->final);

                        // add it to the already parsed list
                        $parsed[$langvar] = true;
                }

                // now echo the final product
                echo $this->final;
        }

        //
        // Function used to make a simple page with no real header/footer
        //
        function simplePage($output, $exit = FALSE)
        {
                global $config;

                include("templates/$config[template]/simple_header.tpl");
                echo $output;
                include("templates/$config[template]/simple_footer.tpl");

                if($exit == TRUE)
                {
                        exit;
                }
        }

        //
        // Function used to make a page that looks like the RPG world, but has an HTML portion in it's middle
        //
        function normalPage($output, $extra = array())
        {
                global $index_message, $user, $config, $debug, $sector, $scroll_chats, $xoffset, $yoffset;

                $hp_graph = makegraph($user[13], $user[14], 'HP: ', 'red');
                $mp_graph = makegraph($user[15], $user[16], 'MP: ', 'blue');

                // see if chat is enabled
                $chatFrame = '';
                if($_SESSION['chat'] == TRUE || (isset($_GET['chat']) && $_GET['chat'] == 1))
                {
                        $chatFrame = '<iframe width="100%" height="161" src="chat.php" frameborder="0" scrolling="'.$scroll_chats.'">Please enable Iframes</iframe>';
                }

                // do we need a + or - for the chat box?
                if($_SESSION['chat'] == TRUE)
                {
                        $chatToggle = '[<a href="index.php?chat=0">-</a>]';
                }
                else
                {
                        $chatToggle = '[<a href="index.php?chat=1">+</a>]';
                }

$script_header = <<<html
                <map name="1">
                </map>
                <script language="javascript" src="includes/javascript.js"></script>
                <div id="dwindow" style="position:absolute;background-color:#EBEBEB;cursor:hand;left:0px;top:0px;display:none;z-index:10000;" onMousedown="initializedrag(event)" onMouseup="stopdrag()" onSelectStart="return false">
                <div align="right" style="background-color:navy"><img src="images/max.gif" id="maxname" onClick="maximize()"><img src="images/close.gif" onClick="closeit()"></div>
                <div id="dwindowcontent" style="height:100%">
                <iframe id="cframe" src="" width=100% height=100%></iframe>
                </div>
                </div>
html;

                // generate a code so that the index messages can be displayed in the top left of the game window
$message_top_left = <<<html
                <div style="position:absolute;left:$xoffset px;top:$yoffset px;visibility: visible;z-index:999;">
                $index_message
                </div>
html;

                // talk and fight buttons (inactive right now)
                $talkButton = '<img src="templates/' . $config['template'] . '/images/action_talk.gif" alt="Talk with nearby charactors" border="0">';
                $fightButton = '<img src="templates/' . $config['template'] . '/images/action_fight.gif" alt="Fight with a nearby monster" border="0">';

                // list of users online
                $online_list = online_list();

                $page = new Template();

                $page->set_files(array(
                'body' => $output));

                        $default = array(
                'page_script_header' => $script_header,
                'talk_button' => $talkButton,
                'fight_button' => $fightButton,
                'chat_toggle' => $chatToggle,
                'chat_frame' => $chatFrame,
                'user_name' => $user['name'],
                'user_level' => $user['level'],
                'user_class' => $user['class'],
                'user_exp' => $user['exp'],
                'hp_graph' => $hp_graph,
                'mp_graph' => $mp_graph,
                'user_gold' => $user['gold'],
                'music_link' => $sector['music'],
                'index_message' => $index_message,
                'index_div' => $message_top_left,
                'online_list' => $online_list);

                        $vars = array_merge($default, $extra);

                $page->assign_vars($vars);

                $page->ppage();

                // debug information
                if($debug == 1)
                {
                        attach_debug();
                }
        }
}
?>
