<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <?=$this->draw('account/menu')?>

    <h1>Pinboard settings</h1>

    <div class="explanation">
      <p>
        To publish bookmarks to Pinboard,
        <a href="https://pinboard.in/settings/password" target="_blank">
          get the API token from the Pinboard settings page
        </a> and enter it below.
      </p>
    </div>

    <form action="/account/pinboard/" class="form-horizontal admin" method="post">
      <div class="form-group">
        <div class="col-md-3">
          <label class="control-label" for="name">API Key</label>
        </div>
        <div class="col-md-4">
          <input type="text"  id="name" placeholder="API Key" class="input col-md-4 form-control" 
                 name="apiKey" value="<?=htmlspecialchars(\Idno\Core\site()->config()->pinboard['apiKey'])?>" >
        </div>
        <div class="col-md-5 config-desc">
          API key in format username:key
        </div>
      </div>

      <div class="controls-save">
        <button type="submit" class="btn btn-primary">Save settings</button>
      </div>
      <?= \Idno\Core\site()->actions()->signForm('/account/pinboard/')?>
    </form>
  </div>
</div>
