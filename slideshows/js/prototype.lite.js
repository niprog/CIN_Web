/*  Prototype JavaScript framework, version 1.4.0
 *  (c) 2005 Sam Stephenson <sam@conio.net>
 *
 *  Prototype is freely distributable under the terms of an MIT-style license.
 *  For details, see the Prototype web site: http://prototype.conio.net/
 *
/*--------------------------------------------------------------------------*/

//note: stripped down version of prototype, to be used with moo.fx by mad4milk (http://moofx.mad4milk.net).

var Class = {
	create: function() {
		return function() {
			this.initialize.apply(this, arguments);
		}
	}
};

Object.extend = function(destination, source) {
	for (var property in source) destination[property] = source[property];
	return destination;
};

Function.prototype.bind = function(object) {
	var __method = this;
	return function() {
		return __method.apply(object, arguments);
	}
};

if (!Array.prototype.forEach){
	Array.prototype.forEach = function(fn, bind){
		for(var i = 0; i < this.length ; i++) fn.call(bind, this[i], i);
	};
}

Array.prototype.each = Array.prototype.forEach;

String.prototype.camelize = function(){
	return this.replace(/-\D/gi, function(match){
		return match.charAt(match.length - 1).toUpperCase();
	});
};

var $A = function(iterable) {
	var nArray = [];
	for (var i = 0; i < iterable.length; i++) nArray.push(iterable[i]);
	return nArray;
};

function $() {
	if (arguments.length == 1) return get$(arguments[0]);
	var elements = [];
	$c(arguments).each(function(el){
		elements.push(get$(el));
	});
	return elements;

	function get$(el){
		if (typeof el == 'string') el = document.getElementById(el);
		return el;
	}
};

if (!window.Element) var Element = {};

Object.extend(Element, {

	remove: function(element) {
		element = $(element);
		element.parentNode.removeChild(element);
	},

	hasClassName: function(element, className) {
		element = $(element);
		return !!element.className.match(new RegExp("\\b"+className+"\\b"));
	},

	addClassName: function(element, className) {
		element = $(element);
		if (!Element.hasClassName(element, className)) element.className = (element.className+' '+className);
	},

	removeClassName: function(element, className) {
		element = $(element);
		if (Element.hasClassName(element, className)) element.className = element.className.replace(className, '');
	}

});

document.getElementsByClassName = function(className){
	var elements = [];
	var all = document.getElementsByTagName('*');
	$A(all).each(function(el){
		if (Element.hasClassName(el, className)) elements.push(el);
	});
	return elements;
};


//(c) 2006 Valerio Proietti (http://mad4milk.net). MIT-style license.
//moo.fx.js - depends on prototype.js OR prototype.lite.js
//version 2.0

var Fx = fx = {};

Fx.Base = function(){};
Fx.Base.prototype = {

	setOptions: function(options){
		this.options = Object.extend({
			onStart: function(){},
			onComplete: function(){},
			transition: Fx.Transitions.sineInOut,
			duration: 500,
			unit: 'px',
			wait: true,
			fps: 50
		}, options || {});
	},

	step: function(){
		var time = new Date().getTime();
		if (time < this.time + this.options.duration){
			this.cTime = time - this.time;
			this.setNow();
		} else {
			setTimeout(this.options.onComplete.bind(this, this.element), 10);
			this.clearTimer();
			this.now = this.to;
		}
		this.increase();
	},

	setNow: function(){
		this.now = this.compute(this.from, this.to);
	},

	compute: function(from, to){
		var change = to - from;
		return this.options.transition(this.cTime, from, change, this.options.duration);
	},

	clearTimer: function(){
		clearInterval(this.timer);
		this.timer = null;
		return this;
	},

	_start: function(from, to){
		if (!this.options.wait) this.clearTimer();
		if (this.timer) return;
		setTimeout(this.options.onStart.bind(this, this.element), 10);
		this.from = from;
		this.to = to;
		this.time = new Date().getTime();
		this.timer = setInterval(this.step.bind(this), Math.round(1000/this.options.fps));
		return this;
	},

	custom: function(from, to){
		return this._start(from, to);
	},

	set: function(to){
		this.now = to;
		this.increase();
		return this;
	},

	hide: function(){
		return this.set(0);
	},

	setStyle: function(e, p, v){
		if (p == 'opacity'){
			if (v == 0 && e.style.visibility != "hidden") e.style.visibility = "hidden";
			else if (e.style.visibility != "visible") e.style.visibility = "visible";
			if (window.ActiveXObject) e.style.filter = "alpha(opacity=" + v*100 + ")";
			e.style.opacity = v;
		} else e.style[p] = v+this.options.unit;
	}

};

Fx.Style = Class.create();
Fx.Style.prototype = Object.extend(new Fx.Base(), {

	initialize: function(el, property, options){
		this.element = $(el);
		this.setOptions(options);
		this.property = property.camelize();
	},

	increase: function(){
		this.setStyle(this.element, this.property, this.now);
	}

});

Fx.Styles = Class.create();
Fx.Styles.prototype = Object.extend(new Fx.Base(), {

	initialize: function(el, options){
		this.element = $(el);
		this.setOptions(options);
		this.now = {};
	},

	setNow: function(){
		for (p in this.from) this.now[p] = this.compute(this.from[p], this.to[p]);
	},

	custom: function(obj){
		if (this.timer && this.options.wait) return;
		var from = {};
		var to = {};
		for (p in obj){
			from[p] = obj[p][0];
			to[p] = obj[p][1];
		}
		return this._start(from, to);
	},

	increase: function(){
		for (var p in this.now) this.setStyle(this.element, p, this.now[p]);
	}

});

//Transitions (c) 2003 Robert Penner (http://www.robertpenner.com/easing/), BSD License.

Fx.Transitions = {
	linear: function(t, b, c, d) { return c*t/d + b; },
	sineInOut: function(t, b, c, d) { return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b; }
};

//by Valerio Proietti (http://mad4milk.net). MIT-style license.
//moo.fx.utils.js - depends on prototype.js OR prototype.lite.js + moo.fx.js
//version 2.0

Fx.Height = Class.create();
Fx.Height.prototype = Object.extend(new Fx.Base(), {

	initialize: function(el, options){
		this.element = $(el);
		this.setOptions(options);
		this.element.style.overflow = 'hidden';
	},

	toggle: function(){
		if (this.element.offsetHeight > 0) return this.custom(this.element.offsetHeight, 0);
		else return this.custom(0, this.element.scrollHeight);
	},

	show: function(){
		return this.set(this.element.scrollHeight);
	},

	increase: function(){
		this.setStyle(this.element, 'height', this.now);
	}

});

Fx.Width = Class.create();
Fx.Width.prototype = Object.extend(new Fx.Base(), {

	initialize: function(el, options){
		this.element = $(el);
		this.setOptions(options);
		this.element.style.overflow = 'hidden';
		this.iniWidth = this.element.offsetWidth;
	},

	toggle: function(){
		if (this.element.offsetWidth > 0) return this.custom(this.element.offsetWidth, 0);
		else return this.custom(0, this.iniWidth);
	},

	show: function(){
		return this.set(this.iniWidth);
	},

	increase: function(){
		this.setStyle(this.element, 'width', this.now);
	}

});

Fx.Opacity = Class.create();
Fx.Opacity.prototype = Object.extend(new Fx.Base(), {

	initialize: function(el, options){
		this.element = $(el);
		this.setOptions(options);
		this.now = 1;
	},

	toggle: function(){
		if (this.now > 0) return this.custom(1, 0);
		else return this.custom(0, 1);
	},

	show: function(){
		return this.set(1);
	},
	
	increase: function(){
		this.setStyle(this.element, 'opacity', this.now);
	}

});
