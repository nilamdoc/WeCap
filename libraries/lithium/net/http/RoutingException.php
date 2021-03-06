<?php
/**
 * li₃: the most RAD framework for PHP (http://li3.me)
 *
 * Copyright 2010, Union of RAD. All rights reserved. This source
 * code is distributed under the terms of the BSD 3-Clause License.
 * The full license text can be found in the LICENSE.txt file.
 */

namespace lithium\net\http;

/**
 * A `RoutingException` is thrown whenever a the `Router` cannot match a set of parameters against
 * the available collection of attached routes.
 */
class RoutingException extends \RuntimeException {

	protected $code = 500;
}

?>