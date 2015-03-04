<?php
/**
 * This file is part of the Internationalization package.
 *
 * Copyright (c) 2010-2015 Pierre Cassat <me@e-piwi.fr> and contributors
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *      http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * The source code of this package is available online at 
 * <http://github.com/atelierspierrot/internationalization>.
 */


namespace I18n;

/**
 * @author  Piero Wbmstr <me@e-piwi.fr>
 */
interface GeneratorInterface
{

    /**
     * @param string $from_file The file to read and parse
     * @param \I18n\I18n $i18n The I18n instance
     */
    public function generate($from_file, \I18n\I18n $i18n);

}

// Endfile