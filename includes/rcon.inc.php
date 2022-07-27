<?php
/************************************************************************
*
* exoGameCtl - Half-Life Server Control Panel
* Copyright (c)2002-2003 Jeff Dodge Technologies.  All Rights Reserved.
*
*************************************************************************
*
*       Author: Jeffrey J. Dodge
*        Email: info@exocontrol.com
*          Web: http://www.exocontrol.com
*     Filename: rcon.inc.php
*  Description: Half-Life Remote Connection (RCON) Class
*      Release: 2.0.7
*
*************************************************************************
*
* Please direct bug reports, suggestions, or feedback to the exoControl
* Forums.  http://www.exocontrol.com/forums
*
*************************************************************************
*
* This software is furnished under a license and may be used and copied
* only  in  accordance  with  the  terms  of such  license and with the
* inclusion of the above copyright notice. This software or any other
* copies thereof may not be provided or otherwise made available to any
* other person. No title to and ownership of the software is hereby
* transferred.
*
* Please see the LICENSE file for the full End User License Agreement
*
*************************************************************************
* $Id: rcon.inc.php,v 2.11 2003/09/21 18:05:41 exodus Exp $
************************************************************************/
   class rcon
   {
      var $challenge_number;
      var $connected;
      var $server_ip;
      var $server_password;
      var $server_port;
      var $socket;

      function rcon()
      {
         $this->challenge_number = 0;
         $this->connected = true;
         $this->server_password = "";
         $this->server_password = 27015;
         $this->server_password = "";
      }

      function connect($server_ip, $server_port, $server_password = "")
      {
         $this->server_ip = gethostbyname($server_ip);
         $this->server_port = $server_port;
         $this->server_password = $server_password;

         $fp = fsockopen("udp://" . $this->server_ip, $this->server_port, &$errno, &$errstr, 5);

         if($fp)
            $this->connected = true;
         else
         {
            $this->connected = false;
            return false;
         }

         $this->socket = $fp;

         return true;
      }

      function rcon_command($command, $pagenumber = 0, $single = true)
      {
         if(!$this->connected)
            return $this->connected;

         if($this->challenge_number == "")
         {
            $challenge = "\xff\xff\xff\xffchallenge rcon\n";
            $buffer = $this->communicate($challenge);

            if(trim($buffer) == "")
            {
               $this->connected = false;
               return false;
            }

           $buffer = explode(" ", $buffer);
           $this->challenge_number = trim($buffer[2]);
        }

        $command = "\xff\xff\xff\xffrcon $this->challenge_number \"$this->server_password\" $command\n";

        $result = "";
        $buffer = "";

        while($pagenumber >= 0)
        {
           $buffer .= $this->communicate($command);

           if($single == true)
              $result = $buffer;
           else
              $result .= $buffer;

           $command = "";
           $pagenumber--;

        }
        return trim($result);
     }

     function communicate($command)
     {
        if(!$this->connected)
           return $this->connected;

        if($command != "")
           fputs($this->socket, $command, strlen($command));

        $buffer = fread ($this->socket, 1);
        $status = socket_get_status($this->socket);
        $buffer .= fread($this->socket, $status["unread_bytes"]);

        if(substr($buffer, 0, 4) == "\xfe\xff\xff\xff")
        {
           $buffer2 = fread ($this->socket, 1);
           $status = socket_get_status($this->socket);
           $buffer2 .= fread($this->socket, $status["unread_bytes"]);

           if(strlen($buffer) > strlen($buffer2))
              $buffer = substr($buffer, 14) . substr($buffer2, 9);
           else
              $buffer = substr($buffer2, 14) . substr($buffer, 9);
        }
        else
           $buffer = substr($buffer, 5);

        return $buffer;
      } 

      function serverinfo()
      {
         if(!$this->connected)
            return $this->connected;

         $status = $this->rcon_command("status");

         if(!$status || trim($status) == "Bad rcon_password.")
            return $status;

         $line = explode("\n", $status);
         $map = substr($line[3], strpos($line[3], ":") + 1);
         $players = trim(substr($line[4], strpos($line[4], ":") + 1));
         $active = explode(" ", $players);

         $result["ip"] = trim(substr($line[2], strpos($line[2], ":") + 1));
         $result["name"] = trim(substr($line[0], strpos($line[0], ":") + 1));
         $result["map"] = trim(substr($map, 0, strpos($map, "at:")));
         $result["mod"] = "Counterstrike " . trim(substr($line[1], strpos($line[1], ":") + 1));
         $result["game"] = "Halflife";
         $result["activeplayers"] = $active[0];
         $result["maxplayers"] = substr($active[2], 1);

         for($i = 1; $i <= $result["activeplayers"]; $i++)
         {
            $tmp = $line[$i + 6];

            if(substr_count($tmp, "#") <= 0)
               break;

            $begin = strpos($tmp, "\"") + 1;
            $end = strrpos($tmp, "\"");
            $result[$i]["name"] = substr($tmp, $begin, $end - $begin);
            $tmp = trim(substr($tmp, $end + 1));

            $end = strpos($tmp, " ");
            $result[$i]["id"] = substr($tmp, 0, $end);
            $tmp = trim(substr($tmp, $end));

            $end = strpos($tmp, " ");
            $result[$i]["wonid"] = substr($tmp, 0, $end);
            $tmp = trim(substr($tmp, $end));

            $end = strpos($tmp, " ");
            $result[$i]["frag"] = substr($tmp, 0, $end);
            $tmp = trim(substr($tmp, $end));

            $end = strpos($tmp, " ");
            $result[$i]["time"] = substr($tmp, 0, $end);
            $tmp = trim(substr($tmp, $end));

            $end = strpos($tmp, " ");
            $result[$i]["ping"] = substr($tmp, 0, $end);
            $tmp = trim(substr($tmp, $end));

            $tmp = trim(substr($tmp, $end));

            $result[$i]["adress"] = $tmp;
         }
         return $result;
      }

      function publicinfo()
      {
         if(!$this->connected)
            return $this->connected;

         $command = "\xff\xff\xff\xffinfo\x00";
         $buffer = $this->communicate($command);

         if(trim($buffer) == "")
         {
            $this->connected = false;
            return false;
         }

         $buffer = explode("\x00", $buffer);

         $result["ip"] = substr($buffer[0], 5);
         $result["name"] = $buffer[1];
         $result["map"] = $buffer[2];
         $result["mod"] = $buffer[3];
         $result["game"] = $buffer[4];
         $result["activeplayers"] = (strlen($buffer[5]) > 1)?ord($buffer[5][0]):"0";
         $result["maxplayers"] = (strlen($buffer[5]) > 1)?ord($buffer[5][1]):"0";

         return $result;
      }

      function serverrules()
      {
         if(!$this->connected)
            return $this->connected;

         $command = "\xff\xff\xff\xffrules\x00";
         $buffer = $this->communicate($command);

         if(trim($buffer) == "")
         {
            $this->connected = false;
            return false;
         }

         $buffer = substr($buffer, 2);
         $buffer = explode("\x00", $buffer);
         $buffer_count = floor(sizeof($buffer) / 2);

         for($i = 0; $i < $buffer_count; $i++)
         {
            $result[$i]["name"] = $buffer[2 * $i];
            $result[$i]["value"] = $buffer[2 * $i + 1];
         }

         ksort($result);
         return $result;
      }

      function servermaps($pagenumber = 0)
      {
         if(!$this->connected)
            return $this->connected;

         $maps = $this->rcon_command("maps *", $pagenumber);

         if(!$maps || trim($maps) == "Bad rcon_password.")
            return $maps;

         $line = explode("\n", $maps);
         $count = sizeof($line);

         for($i = 0; $i <= $count; $i++)
         {
            $text = $line[$i];

            // new for hl1.1.2.0/cs1.6
            if (strstr($text, "scandir failed:"))
                continue;
            if (strstr($text, "----"))
                continue;
            $directory = "";

            // old hl1.1.1.0/cs1.5
            if(strstr($text, "Dir:"))
            {
               $mapcount = 0;
               $directory = strstr($text, " ");

            }
            else if(strstr($text, "(fs)"))
            {
               $mappath = strstr($text, " ");

               if(!($tmpmap = strrchr($mappath, "/")))
                  $tmpmap = $mappath;

               $result[$directory][$i] = substr($tmpmap, 1, strpos($tmpmap, ".") - 1);
            }

            // new for hl1.1.2.0/cs1.6
            if (strstr($text, ".bsp"))
                $result[$directory][$i] = preg_replace("/\.bsp$/", "", $text);

         }
         return $result;
      }

      function serverbanlist($pagenumber = 0)
      {
         if(!$this->connected)
            return $this->connected;

         $banlist = $this->rcon_command("listid", $pagenumber);

         if(!$banlist || trim($banlist) == "Bad rcon_password.")
            return $banlist;

         $line = explode("\n", $banlist);
         $line_count = sizeof($line);

         for ($i = 0; $i < $line_count; $i++)
         {
            $banned = explode(" " , $line[$i]);
            $result[$i]["id"] = $banned[1];
            $result[$i]["timeframe"] = $banned[3];
         }
         return $result;
      }

      function disconnect()
      {
         fclose($this->socket);
         $connected = false;
      }
   }
?>
