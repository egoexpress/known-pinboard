<div class="row">

    <div class="span10 offset1">
        <?=$this->draw('account/menu')?>
        <h1>Pinboard</h1>
    </div>

</div>
<div class="row">
    <div class="span10 offset1">
        <form action="/account/pinboard/" class="form-horizontal" method="post">
            <div class="control-group">
                <div class="controls-config">
                    <p>
                        To publish bookmarks to Pinboard, <a href="https://pinboard.in/settings/password" target="_blank">get the API token from the Pinboard settings page</a> and enter it below.</p>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="name">API Key</label>
                <div class="controls">
                    <input type="text" id="name" placeholder="API Key" class="span4" name="apiKey" value="<?=htmlspecialchars(\Idno\Core\site()->config()->pinboard['apiKey'])?>" >
                </div>
            </div>
            <div class="control-group">
                <div class="controls-save">
                    <button type="submit" class="btn btn-primary">Save settings</button>
                </div>
            </div>
            <?= \Idno\Core\site()->actions()->signForm('/account/pinboard/')?>
        </form>
    </div>
</div>
