<?php
/**
 * li₃: the most RAD framework for PHP (http://li3.me)
 *
 * Copyright 2010, Union of RAD. All rights reserved. This source
 * code is distributed under the terms of the BSD 3-Clause License.
 * The full license text can be found in the LICENSE.txt file.
 */

namespace lithium\tests\mocks\data\model\database;

class MockResult extends \lithium\data\source\Result {

	protected $_records = [];

	protected $_autoConfig = ['resource', 'records'];

	protected function _fetch() {
		if ($this->_records) {
			return [$this->_iterator++, array_shift($this->_records)];
		}
	}
}

?>