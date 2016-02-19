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
 *      HelloWorld.php
 *      
 *      Part of the Prompt Sample App. Copyright Prompt App, Inc 2014 - 2015.
 *      @author Prompt app. Inc.
 */

namespace Bot\HelloWorld;

/**
 * Provides HelloWorld functionality to Prompt bots.
 *
 * @author Prompt app. Inc.
 */

class HelloWorld {
    
    protected $messagetext = '';
    
    public function process($tokens) {
        // Set our class variable with the final message
        $this->messagetext = 'Hello World!';
    }
    
    public function getMessageText() {
        return $this->messagetext;
    }
    
}
