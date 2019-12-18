<?php
  namespace IdnoPlugins\Pinboard {

    class Main extends \Idno\Common\Plugin {

      function registerPages() {
        \Idno\Core\Idno::site()->routes()->addRoute('account/pinboard/?','\IdnoPlugins\Pinboard\Pages\Account');
        \Idno\Core\site()->template()->extendTemplate('account/menu/items','account/pinboard/menu');
      }

      function registerEventHooks() {
        \Idno\Core\site()->syndication()->registerService('pinboard', function () {
          return true;
        }, ['bookmark']);

        // event hook for posting bookmark to Pinboard
        \Idno\Core\Idno::site()->events()->addListener('post/bookmark/pinboard', function (\Idno\Core\Event $event) {
          $object = $event->data()['object'];
          $pinboardObj = $this->connect();
          $url = $object->body;

          // check if we can use the real title here
          $title = $object->getTitle();
          $tags = str_replace('#','',implode(',', $object->getTags()));
          $desc = str_replace($object->getTags(),'',$object->description);
          $desc = html_entity_decode(strip_tags($desc));
          $optionalData = array('tags'=>$tags,'extended'=>$desc);
          $access = $object->getAccess();

          $response = json_decode($pinboardObj->createBookmark($url, $title, $optionalData), true);
          if ($response) {
            $username = explode(':', \Idno\Core\site()->config()->pinboard['apiKey'])[0];
            $object->setPosseLink('pinboard', 'https://www.pinboard.in/u:' . $username);
            $object->save();
          }
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
