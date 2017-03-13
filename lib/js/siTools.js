page = {
  id: function(i, frame)
  {
    if(frame && window.frames[frame])
    {
      page.installInFrame(frame);
      return window.frames[frame].getElementById(i);
    }
    return document.getElementById(i);
  },
  installInFrame: function(frame)
  {
    if(window.frames[frame] && !window.frames[frame].page)
    {
      window.frames[frame].page = window.page;
    }
  },
  PC: false,
  mobile: false,
  touch: false,
  create: function(t)
  {
    return document.createElement(t);
  },
  className: function(className)
  {
    var a = page.tag('*');
    var lista = [];
    var l = a.lenght;
    for(var i=0; i<l; i++)
      if(a[i].className.toString().match('klasa'))
        lista.push(a[i]);
    return lista;
  },
  remove: function(obj)
  {
    if(typeof(obj) == 'string')
    {
      var obj = page.id(obj);
    }
    if(typeof(obj) == 'object')
    {
      obj.parentNode.removeChild(obj);
    }
  },
  cookies:{
    set: function(name, value, minuts)
    {
      if(minuts)
      {
        var date = new Date();
        date.setTime(date.getTime()+(minuts*60000));
        var expires = '; expires='+date.toGMTString();
      }
      else
      {
        var expires = '';
      }
      document.cookie = name+'='+escape(value)+expires;
    },
    get: function(name)
    {
      var nameEQ = name + "=";
      var ca = document.cookie.split(';');
      for(var i=0; i<ca.length;i++)
      {
        var c = ca[i];
        while (c.charAt(0)==' ')
        {
          c = c.substring(1,c.length);
        }
        if (c.indexOf(nameEQ) == 0)
        {
          return unescape(c.substring(nameEQ.length,c.length));
        }
      }
      return null;
    },
    del: function(name)
    {
      page.cookies.set(name, '', -1);
    },
  },
  tag: function(t, i)
  {
    return page.tags(t, i);
  },
  tags: function(t, i)
  {
    if(i === undefined)
      return document.getElementsByTagName(t);
    return document.getElementsByTagName(t)[i];
  },
  height: function(that, inner)
  {
    if(that)
    {
      if(inner)
      {
        if('innerHeight' in that) return that.innerHeight;
        if('clientHeight' in that) return that.clientHeight;
      }
      if('scrollHeight' in that) return that.scrollHeight;
      if('offsetHeight' in that) return that.offsetHeight;
      return;
    }
    if (typeof window.innerWidth!='undefined')
      return window.innerHeight;
    else if(document.documentElement && typeof document.documentElement.clientHeight!='undefined' && document.documentElement.clientHeight!=0)
      return document.documentElement.clientHeight;
    else if (document.body && typeof document.body.clientHeight!='undefined')
      return document.body.clientHeight;
  },
  width: function(that, inner)
  {
    if(that)
    {
      if(inner)
      {
        if('innerWidth' in that) return that.innerWidth;
        if('clientWidth' in that) return that.clientWidth;
      }
      if('offsetWidth' in that) return that.offsetWidth;
      if('scrollWidth' in that) return that.scrollWidth;
      return;
    }
    if (typeof window.innerWidth!='undefined')
      return window.innerWidth;
    else if(document.documentElement && typeof document.documentElement.clientWidth!='undefined' && document.documentElement.clientWidth!=0)
      return document.documentElement.clientWidth;
    else if (document.body && typeof document.body.clientWidth!='undefined')
      return document.body.clientWidth;
  },
  tabelarize: function(o)
  {
    if(typeof(o) == 'object' || typeof(o) == 'array')
    {
      var tab = page.create('table');
      tab.border = 1;
      for(var i in o)
      {
        var tda = page.create('td');
        tda.innerHTML = i;
        var tdb = page.create('td');
        tdb.appendChild(page.tabelarize(o[i]));
        var tr = page.create('tr');
        tr.appendChild(tda);
        tr.appendChild(tdb);
        tab.appendChild(tr);
      }
      return tab;
    }
    var tab = page.create('span');
    tab.innerHTML = o;
    return tab;
  },
  ajax: function()
  {
    var request = false;
    var path = '';
    this.text = '';
    this.url = '';
    var that = this;
    this.init = function(url)
    {
      if(url.substr(0, 7) != 'http://')
      {
        if(url.length == 0)
         that.url = 'ajax.php';
        else
         that.url = url;
      }
      else
        that.url = url;
      if(window.XMLHttpRequest)
      {
        request = new XMLHttpRequest();
      }
      else if (window.ActiveXObject)
      {
        request = new ActiveXObject("Microsoft.XMLHTTP");
      }
    };
    this.add = function(klucz, wart)
    {
      if(!that.path)
        that.path = that.encode(klucz)+'='+that.encode(wart);
      else
        that.path = that.path+'&'+that.encode(klucz)+'='+that.encode(wart);
    };
    this.onSuccess = function(response)
    {
      console.log('this.text = '+response);
    };
    this.onError = function(error)
    {
      alert('Połączenie zakończone błędem '+error.status);
      console.warn(error);
    };
    this.encode = function(str)
    {
      str = (str + '').toString();
      return encodeURIComponent(str).replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28').replace(/\)/g, '%29').replace(/\*/g, '%2A').replace(/%20/g, '+');
    };
    this.send_GET = function()
    {
      if(request)
      {
        if(that.path)
        {
          if(that.url.match('?'))
          {
            var url = that.url + '&' + that.path;
          }
          else
          {
            var url = that.url + '?' + that.path;
          }
        }
        else
          var url = that.url;
        request.open('GET', url);
        request.onreadystatechange = function()
        {
          if(request.readyState == 4)
          {
            if(request.status == 200)
            {
              that.text = request.responseText;
              that.onSuccess(request.responseText);
            }
            else
            {
              that.onError(request);
            }
          }
        };
        request.send(null);
      }
    };
    this.send_POST = function()
    {
      if(request)
      {
        request.open('POST', that.url);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.onreadystatechange = function()
        {
          if(request.readyState == 4)
          {
            if(request.status == 200)
            {
              that.text = request.responseText;
              that.onSuccess(request.responseText);
            }
            else
            {
              that.onError(request);
            }
          }
        };
        request.send(that.path);
      }
    };
    this.send_BOOTH = function()
    {
      if(request)
      {
        if(that.url.match(/\?/))
        {
          var url = that.url + '&' + that.path;
        }
        else
        {
          var url = that.url + '?' + that.path;
        }
        request.open("POST", url);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.onreadystatechange = function()
        {
          if(request.readyState == 4)
          {
            if(request.status == 200)
            {
              that.text = request.responseText;
              that.onSuccess(request.responseText);
            }
            else
            {
              that.onError(request);
            }
          }
        };
        request.send(that.path);
      }
    };
    this.send = function (t)
    {
      if(t) t = t.toUpperCase();
      switch(t)
      {
        default:
          that.send_BOOTH();
         break;

        case 'GET':
          that.send_GET();
         break;

        case 'POST':
          that.send_POST();
         break;
      }
    };
  },
  position: function(target)
  {
    if(target.getBoundingClientRect)
      return target.getBoundingClientRect();
    if(target.offsetParent)
    {
      var obj = target;
      var nleft = obj.offsetLeft;
      var ntop = obj.offsetTop;
      while(obj = obj.offsetParent)
      {
        nleft += obj.offsetLeft;
        ntop += obj.offsetTop;
      }
      var obj = target;
      while(obj = obj.parentNode)
      {
        if(obj.nodeType == 1 && obj.hasAttribute('scroller') && obj.getAttribute('scroller') == 'true')
        {
          nleft -= obj.scrollLeft;
          ntop -= obj.scrollTop;
        }
      }
      return {left:nleft, top:ntop};
    }
    return {left:0, top:0};
  },
  tooltipSet: function(target)
  {
    var hintposition = target.hasAttribute('hintposition')?target.getAttribute('hintposition'):'underleft';
    var position = page.position(target);
    var ntop = 0;
    var nleft = 0;
    var ttext = page.id('tooltip');
    var tgrot = page.id('tooltipImg');

    var text = target.getAttribute('hint');

    if(text[0] == ':')
    {
      text = page.id(text.substr(1)).innerHTML;
    }
    else if(text[0] == '*')
    {
      text = eval(text.substr(1));
    }
    ttext.innerHTML = text;
    switch(hintposition)
    {
      case 'topleft':
        var ttop = position.top - page.height(ttext) - 8;
        var tleft = position.left - 10;
        var itop = position.top - 9;
        var ileft = position.left;
        var nimg = 'bottom';
      break;

      case 'underleft':
        var itop = position.top + page.height(target)+3;
        var ileft = position.left;
        var ttop = itop + 7;
        var tleft = position.left - 10;
        var tend = page.width() - page.width(ttext) - 2;
        var tleft = Math.min(tleft, tend);
        var tleft = Math.max(tleft, 1);
        var ileft = Math.max(ileft, 11);
        var nimg = 'top';
      break;

      case 'underright':
        var itop = position.top + page.height(target)+3;
        var ileft = position.left + page.width(target) - 25;
        var ttop = itop + 7;
        var tleft = position.left + page.width(target) - page.width(ttext) + 10;
        var tleft = Math.max(tleft, 1);
        var tleft = Math.min(tleft, page.width() - page.width(ttext) - 1);
        var nimg = 'top';
      break;

      case 'left':
        var itop = position.top + 6;
        var ileft = position.left;
        var ttop = itop - 5;
        var tleft = ileft - page.width(ttext) + 1;
        if(tleft < 0)
        {
          target.setAttribute('hintposition', 'right');
          //page.tooltipSet(target);
          return;
        }
        var nimg = 'left';
      break;

      case 'right':
        var itop = position.top + 6;
        var ileft = position.left + page.width(target);
        var ttop = itop - 5;
        var tleft = ileft + 7;
        var nimg = 'right';
        if(tleft < 0)
        {
          target.setAttribute('hintposition', 'left');
          page.tooltipSet(target);
          return;
        }
      break;
    }
    tgrot.className = nimg;
    tgrot.style.left = ileft + 'px';
    tgrot.style.top = itop + 'px';
    ttext.style.left = tleft + 'px';
    ttext.style.top = ttop + 'px';
  },
  tooltip: function(e)
  {
    if(!e)e=event;
    if(e.type == 'mouseout')
    {
      setTimeout('page.id(\'tooltips\').className = \'off\';', 10);
      window.tooltipRemove = setTimeout('page.id(\'tooltip\').innerHTML = \'\';', 400);
    }
    else
    {
      if(window.tooltipRemove) clearTimeout(window.tooltipRemove);
      setTimeout('page.id(\'tooltips\').className = \'on\';', 10);
      target = e.target;
      while(!target.hasAttribute('hint') && target.parentNode)
      {
        target = target.parentNode;
      }
      page.tooltipSet(target);
    }
  },
  init: function()
  {
    var all = document.getElementsByTagName('*');
    for(i in all)
    {
      if(i != 'length')
      {
        if(all[i].nodeType == 1 && all[i].hasAttribute('hint'))
        {
          all[i].onmouseover = page.tooltip;
          all[i].onmouseout = page.tooltip;
        }
      }
    }
  },
  sizeof: function(obj)
  {
    if('length' in obj) return obj.length;
    var a = 0;
    for(i in obj)
    {
      if(i != 'length')
      a++;
    }
    return a;
  }, 
  debug: function(js, php)
  {
    console.log('SERVER ERRORS:');
    var line = php.split('\n');
    for(var i in line) console.log(line[i]);
    console.log('CLIENT ERRORS:');
    var line = js.split('\n');
    for(var i in line) console.log(line[i]);
  },
  fullscreen: function(element, state)
  {
    if(element == undefined)
    {
      if('fullScreen' in document) return document.fullScreen;
      else if('webkitIsFullScreen' in document) return document.webkitIsFullScreen;
      else if('mozFullScreen' in document) return document.mozFullScreen;
      else if('oFullScreen' in document) return document.oFullScreen;
      else if('msFullScreen' in document) return document.msFullScreen;
    }
    else if(state == true)
    {
      if('requestFullScreen' in element) element.requestFullScreen();
      else if('webkitRequestFullScreen' in element) element.webkitRequestFullScreen();
      else if('mozRequestFullScreen' in element) element.mozRequestFullScreen();
      else if('oRequestFullScreen' in element) element.oRequestFullScreen();
      else if('msRequestFullScreen' in element) element.msRequestFullScreen();
    }
    else if(state == false)
    {
      if('cancelFullScreen' in element) element.cancelFullScreen();
      else if('webkitCancelFullScreen' in element) element.webkitCancelFullScreen();
      else if('mozCancelFullScreen' in element) element.mozCancelFullScreen();
      else if('oCancelFullScreen' in element) element.mozCancelFullScreen();
      else if('msCancelFullScreen' in element) element.msCancelFullScreen();
    }
  },
};

if(screen.width < 600 || screen.height < 600)
  page.mobile = true;
if('Touch' in window)
  page.touch = true;
if(screen.width > 400 && screen.height > 400 && page.touch == false)
  page.PC = true;
Element.prototype.moveTo = function(l, t)
{
  if(t !== false)  this.style.top = t+'px';
  if(l !== false)  this.style.left = l+'px';
};
Element.prototype.move = function(l, t)
{
  if(t !== false)  this.style.top = (parseFloat(this.style.top)+t)+'px';
  if(l !== false)  this.style.left = (parseFloat(this.style.left)+l)+'px';
};
Element.prototype.resizeTo = function(w, h)
{
  if(w !== false)  this.style.width = w+'px';
  if(h !== false)  this.style.height = h+'px';
};
