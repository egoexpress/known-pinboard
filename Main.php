<?php
  namespace IdnoPlugins\Pinboard {

    class Main extends \Idno\Common\Plugin {

      function registerPages() {
        \Idno\Core\site()->addPageHandler('account/pinboard/?','\IdnoPlugins\Pinboard\Pages\Account');
        \Idno\Core\site()->template()->extendTemplate('account/menu/items','account/pinboard/menu');
      }

      function registerEventHooks() {
        \Idno\Core\site()->syndication()->registerService('pinboard', function () {
          return true;
        }, ['bookmark']);

        \Idno\Core\site()->addEventHook('post/bookmark/pinboard', function (\Idno\Core\Event $event) {
          // TODO: add code here
        });
      }

      function connect(){
      	require_once(dirname(__FILE__) . '/external/pinboard.php');
        $apiKey = \Idno\Core\site()->config()->pinboard['apiKey'];
        $pinboard = new \Pinboard($apiKey);
        return $pinboard;
      }
    }
  }
