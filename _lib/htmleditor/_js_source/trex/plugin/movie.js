TrexConfig.addTool(
    "cinema", 
    {
            wysiwygonly: true,
            sync: false,
            status: true
    }
);
Trex.Tool.Cinema = Trex.Class.create({
    $const: {
            __Identity: 'cinema'
    },
    $extend: Trex.Tool,
    oninitialized: function(config) {
        var _tool = this;
        var _canvas = this.canvas;
        
        this.weave.bind(this)(
            new Trex.Button(this.buttonCfg),
            new Trex.Menu.Cinema(this.menuCfg),
            function(html) {
                _canvas.execute(function(processor) {
                        processor.pasteContent(html, false);
                });
            },
            function() {
                return _canvas.query(function(processor) {
                        return processor.getText();
                });
            }
        );
    }
});

Trex.Menu.Cinema = Trex.Class.create({
    $extend: Trex.Menu,
    $mixins: [Trex.I.JSRequester],
    ongenerated: function(config) {
        var _menu = this;
        
        var _template = new Template('<div><img src="#{thumbnail}" align="left"/><h5><a href="#{link}" target="_blank">#{title}</a></h5><dl><dt>감독</dt><dd>#{director}</dd><dt>배우</dt><dd>#{actor}</dd></dl></div>');
        window.drawMovie = function(data) {
            var _item = data.channel.item[0];
            var _html = _template.evaluate({
                seq: i,
                thumbnail: _item.thumbnail.pluck('content').join(","),
                title: _item.title.pluck('content').join(","),
                link: _item.title.pluck('link').join(","),
                director: _item.director.pluck('content').join(","),
                actor: _item.actor.pluck('content').join(",")
            });
            _menu.elMenu.innerHTML += _html;
            $tx.observe($tom.collect(_menu.elMenu, "img"), "click", function(ev) {
                _menu.onSelect(ev, _html);
            });
        };
    },
    onregenerated: function(config) {
        var _initData = this.initHandler().stripTags().trim();
        if(_initData.length == 0) {
            return;
        }
        this.elMenu.innerHTML = "선택된 단어 : " + _initData;
        this.importScript("http://apis.daum.net/contents/movie?apikey=##KEY##&q=" + encodeURIComponent(_initData) + "&result=4&pageno=1&output=json&callback=drawMovie");
    }
});