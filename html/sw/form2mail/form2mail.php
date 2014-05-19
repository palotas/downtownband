<?
  error_reporting ( E_ALL ^ E_NOTICE ^ E_WARNING );

  $var_to = "michael.palotas@gridfusion.net";

  $var_smtp_server   = "";
  $var_smtp_user     = "";
  $var_smtp_password = "";

  $var_db_path = "/var/html/eco1206226/files/f2m.db";


  if ( strpos ( $_SERVER["HTTP_REFERER"], sprintf ( "%s/", $_SERVER["SERVER_NAME"] ) ) === false )
     { header ( "Location: http://www.innter.net/" );
       exit;
     }

  if ( !$_POST["_url"] || !$_POST["_subject"] || !$_POST["_email"] )
     { header ( sprintf ( "Location: %s", $_SERVER["HTTP_REFERER"] ) );
       exit;
     }

  if ( filter_var ( $_POST["_email"], FILTER_VALIDATE_EMAIL ) === false )
     { header ( sprintf ( "Location: %s", $_SERVER["HTTP_REFERER"] ) );
       exit;
     }

  while ( list ( $var_key, $var_value ) = each ( $_POST ) )
        { if ( strpos ( $var_key, "_" ) === 0 || $var_value == "" ) { continue; }

          $var_message .= sprintf ( "%s => %s\n", $var_key, $var_value );
        }

  if ( $var_message == "" )
     { header ( sprintf ( "Location: %s", $_POST["_url"] ) );
       exit;
     }

  $var_content = implode ( " ", $_POST );
  $var_matches = preg_match_all ( "/(([*+!.&#$|'\%\/0-9a-z^_`{}=?~:-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,4}))/i", $var_content, $arr_matches );

  if ( $var_matches > 1 )
     { header ( sprintf ( "Location: %s", $_POST["_url"] ) );
       exit;
     }

  $var_md5 = md5 ( $var_content );

  $obj_db = dba_open ( $var_db_path, "cd", "db4" );

  $var_key = dba_firstkey ( $obj_db );

  while ( $var_key != false )
        { $var_value = dba_fetch ( $var_key, $obj_db );

          if ( $var_value < time ( ) - 86400 * 7 )
             { $arr_expired[] = $var_key;
             }

          $var_key = dba_nextkey ( $obj_db );
        }

  foreach ( $arr_expired as $var_key )
          { dba_delete ( $var_key, $obj_db );
          }

  if ( dba_exists ( $var_md5, $obj_db ) )
     { dba_close ( $obj_db );

       header ( sprintf ( "Location: %s", $_POST["_url"] ) );
       exit;
     }

  dba_insert ( $var_md5, time ( ), $obj_db );

  dba_optimize ( $obj_db );
  dba_close ( $obj_db );

  require ( "Mail.php" );
  require ( "Mail/mime.php" );

  $res_mime = new Mail_mime ( );

  if ( $var_smtp_server && $var_smtp_user && $var_smtp_password )
     { $res_mail = Mail::factory ( "smtp", array ( "host"     => $var_smtp_server,
                                                   "auth"     => true,
                                                   "username" => $var_smtp_user,
                                                   "password" => $var_smtp_password
                                                 )
                                 );
     }
  else
     { $res_mail = Mail::factory ( "mail" );
     }

  $arr_headers["From"]        = $_POST["_email"];
  $arr_headers["Return-Path"] = $var_to;
  $arr_headers["Sender"]      = $var_to;
  $arr_headers["To"]          = $var_to;
  $arr_headers["Subject"]     = $_POST["_subject"];

  $res_mime->setTXTBody ( $var_message );

  $var_email_body = $res_mime->get ( );
  $var_email_headers = $res_mime->headers ( $arr_headers );

  $res_mail->send ( $var_to, $var_email_headers, $var_email_body );

  header ( sprintf ( "Location: %s", $_POST["_url"] ) );
?>
