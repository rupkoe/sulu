define(["services/husky/mediator"],function(a){"use strict";return{showDialog:function(b,c){$.isArray(b)||(b=[b]),0!==b.length&&a.emit("sulu.overlay.show-warning","sulu.overlay.be-careful","sulu.overlay.delete-desc",null,c.bind(this,!0))}}});