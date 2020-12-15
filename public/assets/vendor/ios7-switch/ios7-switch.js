function Switch(input) {
  if ('checkbox' !== input.type) throw new Error('You can\'t make Switch out of non-checkbox input');
  this.input = input;
  this.input.style.display = 'none'; 
  this.el = document.createElement('div');
  this.el.className = 'ios-switch';
  this._prepareDOM();
  this.input.parentElement.insertBefore(this.el, this.input);
  if (this.input.checked) this.turnOn()
}
Switch.addClass = function( el, className) {
  if (el.classList) {
    el.classList.add(className);
  } else {
    el.className += ' ' + className;
  }
};
Switch.removeClass = function( el, className) {
  if (el.classList) {
    el.classList.remove(className);
  } else {
    el.className = el.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
  }
};
Switch.hasClass = function(el, className) {
  if (el.classList) {
    return el.classList.contains(className);
  } else {
    return new RegExp('(^| )' + className + '( |$)', 'gi').test(el.className);
  }
};
Switch.prototype.toggle = function() {
  if( Switch.hasClass(this.el, 'on') ){
    this.turnOff();
  } else {
    this.turnOn();
  }
  this.triggerChange();
};
Switch.prototype.turnOn = function() {
  Switch.addClass(this.el, 'on');
  Switch.removeClass(this.el, 'off');
  this.input.checked = true;
};
Switch.prototype.turnOff = function() {
  Switch.removeClass(this.el, 'on');
  Switch.addClass(this.el, 'off');
  this.input.checked = false;
}
Switch.prototype.triggerChange = function() {
  if ("fireEvent" in this.input){
    this.input.fireEvent("onchange");
  } else {
    var evt = document.createEvent("HTMLEvents");
    evt.initEvent("change", false, true);
    this.input.dispatchEvent(evt);
  }
};
Switch.prototype._prepareDOM = function() {
  var onBackground = document.createElement('div');
  onBackground.className = 'on-background background-fill';
  var stateBackground = document.createElement('div');
  stateBackground.className = 'state-background background-fill';
  var handle = document.createElement('div');
  handle.className = 'handle';
  this.el.appendChild(onBackground);
  this.el.appendChild(stateBackground);
  this.el.appendChild(handle);
};
