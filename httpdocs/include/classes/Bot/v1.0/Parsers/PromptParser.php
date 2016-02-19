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
 *      PromptParser.php
 *      
 *      Part of the Prompt Sample App. Copyright Prompt App, Inc 2014 - 2015.
 *      @author Prompt app. Inc.
 */

namespace Bot\Parsers;

/**
 * The is a default parser file for parsing the incoming message. 
 * You do not need to use this and can create your own variation.
 * Best practice is to assume a message will be tokenized, so the key data can
 * be referenced by your subsequent business logic.
 *
 * @author Prompt app. Inc.
 */

class PromptParser {

    public function getTokens($message) {
        $tokens = array('foo' => NULL);
        
        return $tokens;
    }
    
}
