<?php
/*
 * Copyright (C) 2016 Prompt App, Inc
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 *      BotConfig.php
 *      
 *      Part of the Prompt Sample App. Copyright Prompt App, Inc 2014 - 2015.
 *      @author Prompt app. Inc.
 */

namespace Bot\Config;

use Prompt\Bot\Config;

/**
 *      This class provides the server environment based on the hosted domain name.
 *
 *      Example:
 *      <code>
 *      $ServiceConfig = new Prompt\BotConfig();
 *      $ServiceConfig->getValue('BOT_ENVIRONMENT')
 * 
 *      or statically;
 * 
 *      Bot\Config\BotConfig::getValue('BOT_ENVIRONMENT');
 * 
 *      </code>
 * 
 * @author Prompt app. Inc.
 *
*/

class BotConfig extends Config\ServiceConfiguration {
	
	protected $configArr = array(            
            
                        # Note the key is normally a host name or file path                                                
                        
                        # 'default' production service variables. 
                        # BotConfig will fall back to these if no other hostname matches
			"default"=>array(                            
                                            "BOT_ENVIRONMENT" => 'prod',
                                            "MYSQL_HOSTNAME"=>"localhost",
                                            "MYSQL_USERNAME"=>"foo",
                                            "MYSQL_PASSWORD"=>"bar",
                                            "MYSQL_DATABASE"=>"foobar",
                                            ),   
            
                        # Alternative dev environment
			"mydevhostname.foo"=>array(                            
                                            "BOT_ENVIRONMENT" => 'dev',
                                            "MYSQL_HOSTNAME"=>"localhost",
                                            "MYSQL_USERNAME"=>"foo",
                                            "MYSQL_PASSWORD"=>"bar",
                                            "MYSQL_DATABASE"=>"foobar",
                                            ), 
            
                        # Local development enviroment
			"localhost"=>array(                            
                                            "BOT_ENVIRONMENT" => 'dev',
                                            "MYSQL_HOSTNAME"=>"localhost",
                                            "MYSQL_USERNAME"=>"foo",
                                            "MYSQL_PASSWORD"=>"bar",
                                            "MYSQL_DATABASE"=>"foobar",
                                            ),             
            
                        # To avoid repetition, you can also alias an existing config array
                        "mybot.local"=>array('alias'=>'default'),
									
	);	
}
