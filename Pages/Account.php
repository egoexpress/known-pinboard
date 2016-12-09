<?php

  namespace IdnoPlugins\Pinboard\Pages {

    class Account extends \Idno\Common\Page {

      function getContent() {
        $this->gatekeeper(); // Logged-in users only
        $t = \Idno\Core\site()->template();
        $body = $t->draw('account/pinboard');
        $t->__(['title' => 'Pinboard', 'body' => $body])->drawPage();
      }

      function postContent() {
        $this->gatekeeper(); // Logged-in users only
        $apiKey = $this->getInput('apiKey');
        \Idno\Core\site()->config->config['pinboard'] = [
          'apiKey' => $apiKey
        ];
        \Idno\Core\site()->config()->save();
        \Idno\Core\site()->session()->addMessage('Your Pinboard API token was saved.');
        $this->forward('/account/pinboard/');
      }
    }
  }
