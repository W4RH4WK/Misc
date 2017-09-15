<div class="modal hide fade" id="modal-help">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">x</button>
        <h3>Custom Pages Help</h3>
    </div>
    <div class="modal-body">
        <p>This component allows you to create custom pages. You can even use
        markdown</p>

        <h4>Id</h4>
        <blockquote>
            The id is used to identify every entry. It has to be unique and you
            don't need to care about it anyway. When a new entry is created,
            the database will automatically add a new id to your entry.
        </blockquote>

        <h4>Name</h4>
        <blockquote>
            Because remembering ids is hard and stupid, each page has it's own
            (unique) name, so you know exactly what page to edit / remove
        </blockquote>

        <h4>Markdown</h4>
        <blockquote>
            If the markdown checkbox is checked, the page's content will be
            rendered using a markdown to html converter.
        </blockquote>

        <h4>Options</h4>
        <blockquote>
            When you create a new page, you can add the new page to your main
            navigation if you wish, and you can also create an RSS feed
            mentioning the new page
        </blockquote>

        <h4>Additional</h4>
        <blockquote>
            <a href="http://daringfireball.net/projects/markdown/">Here is a reference to markdown</a><br />
            <br />
            If markdown is too complicated for you:
            <ol>
                <li>create a word document</li>
                <li>copy the content to <a href="http://word2cleanhtml.com/">this page</a></li>
                <li>hit the convert button</li>
                <li>copy the new text to the pages markitup box</li>
                <li><strong>uncheck</strong> markdown</li>
            </ol>
        </blockquote>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-primary" data-dismiss="modal"><i class="icon-remove icon-white"></i> Close</a>
    </div>
</div>
