(function() {
    tinymce.create('tinymce.plugins.Wptuts', {
        init : function(ed, url) {

            ed.addButton('youtube_embed', {
                title : 'Add youtube embed Shortcode',
                cmd : 'youtube_embed',
                image : url + '/../images/youtube_icon.png'
            });
            
            ed.addButton('vimeo_embed', {
                title : 'Add vimeo embed Shortcode',
                cmd : 'vimeo_embed',
                image : url + '/../images/vimeo_icon.png'
            });
            ed.addButton('half_cols', {
                title : 'Add Columns 1/2 1/2 Shortcode',
                cmd : 'half_cols',
                image : url + '/../images/column-two-icon.png'
            });
            ed.addButton('one_third_cols', {
                title : 'Add Columns 1/3 1/3 1/3 Shortcode',
                cmd : 'one_third_cols',
                image : url + '/../images/column-tree-icon.png'
            });
            ed.addButton('two_third_cols', {
                title : 'Add Columns 2/3 1/3 Shortcode',
                cmd : 'two_third_cols',
                image : url + '/../images/column-left-icon.png'
            });
            ed.addButton('buttonsc', {
                title : 'Add Button Shortcode',
                cmd : 'buttonsc',
                image : url + '/../images/buttonsc.png'
            });
 
            ed.addCommand('youtube_embed', function() {
                var link = prompt("Insert youtube link"),
                    shortcode;
                if (link !== null) {
                    shortcode = '[youtube_embed src="' + link + '"/]';
                    ed.execCommand('mceInsertContent', 0, shortcode);
                }
            });
            ed.addCommand('vimeo_embed', function() {
                var link = prompt("Insert vimeo link"),
                    shortcode;
                if (link !== null) {
                    shortcode = '[vimeo_embed src="' + link + '"/]';
                    ed.execCommand('mceInsertContent', 0, shortcode);
                }
            });
            ed.addCommand('half_cols', function() {
                var shortcode;
                    shortcode = '[first_half][/first_half] [last_half][/last_half]';
                    ed.execCommand('mceInsertContent', 0, shortcode);
            });
            ed.addCommand('one_third_cols', function() {
                var shortcode;
                    shortcode = '[first_third][/first_third] [second_third][/second_third] [last_third][/last_third]';
                    ed.execCommand('mceInsertContent', 0, shortcode);
            });
            ed.addCommand('two_third_cols', function() {
                var shortcode;
                    shortcode = '[two_third][/two_third] [last_third][/last_third]';
                    ed.execCommand('mceInsertContent', 0, shortcode);
            });
            ed.addCommand('buttonsc', function() {
                var shortcode;
                    shortcode = '[button href="INSERT LINK HERE" name="INSERT NAME HERE" target="INSERT TARGET HERE"]';
                    ed.execCommand('mceInsertContent', 0, shortcode);
            });
        },
        // ... Hidden code
    });
    // Register plugin
    tinymce.PluginManager.add( 'wptuts', tinymce.plugins.Wptuts );
})();
(function() {
    tinymce.create('tinymce.plugins.Wptuts', {
        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init : function(ed, url) {
            
        },
 
        /**
         * Creates control instances based in the incomming name. This method is normally not
         * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
         * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
         * method can be used to create those.
         *
         * @param {String} n Name of the control to create.
         * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
         * @return {tinymce.ui.Control} New control instance or null if no control was created.
         */
        createControl : function(n, cm) {
            return null;
        },
 
        /**
         * Returns information about the plugin as a name/value array.
         * The current keys are longname, author, authorurl, infourl and version.
         *
         * @return {Object} Name/value array containing information about the plugin.
         */
        getInfo : function() {
            return {
                longname : 'Wptuts Buttons',
                author : 'Lee',
                authorurl : 'http://wp.tutsplus.com/author/leepham',
                infourl : 'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/example',
                version : "0.1"
            };
        }
    });
 
    // Register plugin
    tinymce.PluginManager.add( 'wptuts', tinymce.plugins.Wptuts );
})();
