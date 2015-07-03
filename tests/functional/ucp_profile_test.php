<?php
/**
 *
 * Ajax Shoutbox extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2014 Paul Sohier <http://www.ajax-shoutbox.com>
 * @license       GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace paul999\ajaxshoutbox\tests\functional;

/**
 * Class ucp_profile_test
 * @package paul999\ajaxshoutbox\tests\functional
 * @group functional
 */
class ucp_profile_test extends \phpbb_functional_test_case{

    static protected function setup_extensions()
    {
        return array('paul999/ajaxshoutbox');
    }
}