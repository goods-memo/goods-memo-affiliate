<?php

/*
 * Copyright (C) 2018 Goods Memo.
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301  USA
 */

namespace goodsmemo\network;

/**
 * Description of URLInfo
 *
 * @author Goods Memo
 */
class URLInfo {

    //http://php.net/manual/ja/function.parse-url.php
    //scheme
    private $hostname;
    private $path;

    public function getHostname() {
	return $this->hostname;
    }

    public function getPath() {
	return $this->path;
    }

    public function setHostname($hostname) {
	$this->hostname = $hostname;
    }

    public function setPath($path) {
	$this->path = $path;
    }

}
