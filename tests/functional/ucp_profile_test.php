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

    public function test_ucp_page() {
        $this->add_lang_ext('paul999/ajaxshoutbox', 'ajax_shoutbox');
        $this->login();

        /** @var \Symfony\Component\DomCrawler\Crawler $crawler */
        $crawler = self::request('GET', 'ucp.php?i=ucp_prefs&mode=personal');
        $this->assertContains($this->lang('AJAXSHOUTBOX_BOARD_DATE_FORMAT'), $crawler->filter('#ajaxshoutbox_format_label')->text());

        $form = $crawler->selectButton($this->lang['SUBMIT'])->form();

        self::$client->submit($form);
        self::assert_response_html();
    }
}