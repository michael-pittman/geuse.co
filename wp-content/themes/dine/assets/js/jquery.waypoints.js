/*!
dineWaypoints - 4.0.0
Copyright © 2011-2015 Caleb Troughton
Licensed under the MIT license.
https://github.com/imakewebthings/dine_waypoints/blob/master/licenses.txt
*/
(function() {
  'use strict'

  var keyCounter = 0
  var alldineWaypoints = {}

  /* http://imakewebthings.com/dine_waypoints/api/dine_waypoint */
  function dineWaypoint(options) {
    if (!options) {
      throw new Error('No options passed to dineWaypoint constructor')
    }
    if (!options.element) {
      throw new Error('No element option passed to dineWaypoint constructor')
    }
    if (!options.handler) {
      throw new Error('No handler option passed to dineWaypoint constructor')
    }

    this.key = 'dine_waypoint-' + keyCounter
    this.options = dineWaypoint.Adapter.extend({}, dineWaypoint.defaults, options)
    this.element = this.options.element
    this.adapter = new dineWaypoint.Adapter(this.element)
    this.callback = options.handler
    this.axis = this.options.horizontal ? 'horizontal' : 'vertical'
    this.enabled = this.options.enabled
    this.triggerPoint = null
    this.group = dineWaypoint.Group.findOrCreate({
      name: this.options.group,
      axis: this.axis
    })
    this.context = dineWaypoint.Context.findOrCreateByElement(this.options.context)

    if (dineWaypoint.offsetAliases[this.options.offset]) {
      this.options.offset = dineWaypoint.offsetAliases[this.options.offset]
    }
    this.group.add(this)
    this.context.add(this)
    alldineWaypoints[this.key] = this
    keyCounter += 1
  }

  /* Private */
  dineWaypoint.prototype.queueTrigger = function(direction) {
    this.group.queueTrigger(this, direction)
  }

  /* Private */
  dineWaypoint.prototype.trigger = function(args) {
    if (!this.enabled) {
      return
    }
    if (this.callback) {
      this.callback.apply(this, args)
    }
  }

  /* Public */
  /* http://imakewebthings.com/dine_waypoints/api/destroy */
  dineWaypoint.prototype.destroy = function() {
    this.context.remove(this)
    this.group.remove(this)
    delete alldineWaypoints[this.key]
  }

  /* Public */
  /* http://imakewebthings.com/dine_waypoints/api/disable */
  dineWaypoint.prototype.disable = function() {
    this.enabled = false
    return this
  }

  /* Public */
  /* http://imakewebthings.com/dine_waypoints/api/enable */
  dineWaypoint.prototype.enable = function() {
    this.context.refresh()
    this.enabled = true
    return this
  }

  /* Public */
  /* http://imakewebthings.com/dine_waypoints/api/next */
  dineWaypoint.prototype.next = function() {
    return this.group.next(this)
  }

  /* Public */
  /* http://imakewebthings.com/dine_waypoints/api/previous */
  dineWaypoint.prototype.previous = function() {
    return this.group.previous(this)
  }

  /* Private */
  dineWaypoint.invokeAll = function(method) {
    var alldineWaypointsArray = []
    for (var dine_waypointKey in alldineWaypoints) {
      alldineWaypointsArray.push(alldineWaypoints[dine_waypointKey])
    }
    for (var i = 0, end = alldineWaypointsArray.length; i < end; i++) {
      alldineWaypointsArray[i][method]()
    }
  }

  /* Public */
  /* http://imakewebthings.com/dine_waypoints/api/destroy-all */
  dineWaypoint.destroyAll = function() {
    dineWaypoint.invokeAll('destroy')
  }

  /* Public */
  /* http://imakewebthings.com/dine_waypoints/api/disable-all */
  dineWaypoint.disableAll = function() {
    dineWaypoint.invokeAll('disable')
  }

  /* Public */
  /* http://imakewebthings.com/dine_waypoints/api/enable-all */
  dineWaypoint.enableAll = function() {
    dineWaypoint.invokeAll('enable')
  }

  /* Public */
  /* http://imakewebthings.com/dine_waypoints/api/refresh-all */
  dineWaypoint.refreshAll = function() {
    dineWaypoint.Context.refreshAll()
  }

  /* Public */
  /* http://imakewebthings.com/dine_waypoints/api/viewport-height */
  dineWaypoint.viewportHeight = function() {
    return window.innerHeight || document.documentElement.clientHeight
  }

  /* Public */
  /* http://imakewebthings.com/dine_waypoints/api/viewport-width */
  dineWaypoint.viewportWidth = function() {
    return document.documentElement.clientWidth
  }

  dineWaypoint.adapters = []

  dineWaypoint.defaults = {
    context: window,
    continuous: true,
    enabled: true,
    group: 'default',
    horizontal: false,
    offset: 0
  }

  dineWaypoint.offsetAliases = {
    'bottom-in-view': function() {
      return this.context.innerHeight() - this.adapter.outerHeight()
    },
    'right-in-view': function() {
      return this.context.innerWidth() - this.adapter.outerWidth()
    }
  }

  window.dineWaypoint = dineWaypoint
}())
;(function() {
  'use strict'

  function requestAnimationFrameShim(callback) {
    window.setTimeout(callback, 1000 / 60)
  }

  var keyCounter = 0
  var contexts = {}
  var dineWaypoint = window.dineWaypoint
  var oldWindowLoad = window.onload

  /* http://imakewebthings.com/dine_waypoints/api/context */
  function Context(element) {
    this.element = element
    this.Adapter = dineWaypoint.Adapter
    this.adapter = new this.Adapter(element)
    this.key = 'dine_waypoint-context-' + keyCounter
    this.didScroll = false
    this.didResize = false
    this.oldScroll = {
      x: this.adapter.scrollLeft(),
      y: this.adapter.scrollTop()
    }
    this.dine_waypoints = {
      vertical: {},
      horizontal: {}
    }

    element.dine_waypointContextKey = this.key
    contexts[element.dine_waypointContextKey] = this
    keyCounter += 1

    this.createThrottledScrollHandler()
    this.createThrottledResizeHandler()
  }

  /* Private */
  Context.prototype.add = function(dine_waypoint) {
    var axis = dine_waypoint.options.horizontal ? 'horizontal' : 'vertical'
    this.dine_waypoints[axis][dine_waypoint.key] = dine_waypoint
    this.refresh()
  }

  /* Private */
  Context.prototype.checkEmpty = function() {
    var horizontalEmpty = this.Adapter.isEmptyObject(this.dine_waypoints.horizontal)
    var verticalEmpty = this.Adapter.isEmptyObject(this.dine_waypoints.vertical)
    if (horizontalEmpty && verticalEmpty) {
      this.adapter.off('.dine_waypoints')
      delete contexts[this.key]
    }
  }

  /* Private */
  Context.prototype.createThrottledResizeHandler = function() {
    var self = this

    function resizeHandler() {
      self.handleResize()
      self.didResize = false
    }

    this.adapter.on('resize.dine_waypoints', function() {
      if (!self.didResize) {
        self.didResize = true
        dineWaypoint.requestAnimationFrame(resizeHandler)
      }
    })
  }

  /* Private */
  Context.prototype.createThrottledScrollHandler = function() {
    var self = this
    function scrollHandler() {
      self.handleScroll()
      self.didScroll = false
    }

    this.adapter.on('scroll.dine_waypoints', function() {
      if (!self.didScroll || dineWaypoint.isTouch) {
        self.didScroll = true
        dineWaypoint.requestAnimationFrame(scrollHandler)
      }
    })
  }

  /* Private */
  Context.prototype.handleResize = function() {
    dineWaypoint.Context.refreshAll()
  }

  /* Private */
  Context.prototype.handleScroll = function() {
    var triggeredGroups = {}
    var axes = {
      horizontal: {
        newScroll: this.adapter.scrollLeft(),
        oldScroll: this.oldScroll.x,
        forward: 'right',
        backward: 'left'
      },
      vertical: {
        newScroll: this.adapter.scrollTop(),
        oldScroll: this.oldScroll.y,
        forward: 'down',
        backward: 'up'
      }
    }

    for (var axisKey in axes) {
      var axis = axes[axisKey]
      var isForward = axis.newScroll > axis.oldScroll
      var direction = isForward ? axis.forward : axis.backward

      for (var dine_waypointKey in this.dine_waypoints[axisKey]) {
        var dine_waypoint = this.dine_waypoints[axisKey][dine_waypointKey]
        var wasBeforeTriggerPoint = axis.oldScroll < dine_waypoint.triggerPoint
        var nowAfterTriggerPoint = axis.newScroll >= dine_waypoint.triggerPoint
        var crossedForward = wasBeforeTriggerPoint && nowAfterTriggerPoint
        var crossedBackward = !wasBeforeTriggerPoint && !nowAfterTriggerPoint
        if (crossedForward || crossedBackward) {
          dine_waypoint.queueTrigger(direction)
          triggeredGroups[dine_waypoint.group.id] = dine_waypoint.group
        }
      }
    }

    for (var groupKey in triggeredGroups) {
      triggeredGroups[groupKey].flushTriggers()
    }

    this.oldScroll = {
      x: axes.horizontal.newScroll,
      y: axes.vertical.newScroll
    }
  }

  /* Private */
  Context.prototype.innerHeight = function() {
    /*eslint-disable eqeqeq */
    if (this.element == this.element.window) {
      return dineWaypoint.viewportHeight()
    }
    /*eslint-enable eqeqeq */
    return this.adapter.innerHeight()
  }

  /* Private */
  Context.prototype.remove = function(dine_waypoint) {
    delete this.dine_waypoints[dine_waypoint.axis][dine_waypoint.key]
    this.checkEmpty()
  }

  /* Private */
  Context.prototype.innerWidth = function() {
    /*eslint-disable eqeqeq */
    if (this.element == this.element.window) {
      return dineWaypoint.viewportWidth()
    }
    /*eslint-enable eqeqeq */
    return this.adapter.innerWidth()
  }

  /* Public */
  /* http://imakewebthings.com/dine_waypoints/api/context-destroy */
  Context.prototype.destroy = function() {
    var alldineWaypoints = []
    for (var axis in this.dine_waypoints) {
      for (var dine_waypointKey in this.dine_waypoints[axis]) {
        alldineWaypoints.push(this.dine_waypoints[axis][dine_waypointKey])
      }
    }
    for (var i = 0, end = alldineWaypoints.length; i < end; i++) {
      alldineWaypoints[i].destroy()
    }
  }

  /* Public */
  /* http://imakewebthings.com/dine_waypoints/api/context-refresh */
  Context.prototype.refresh = function() {
    /*eslint-disable eqeqeq */
    var isWindow = this.element == this.element.window
    /*eslint-enable eqeqeq */
    var contextOffset = isWindow ? undefined : this.adapter.offset()
    var triggeredGroups = {}
    var axes

    this.handleScroll()
    axes = {
      horizontal: {
        contextOffset: isWindow ? 0 : contextOffset.left,
        contextScroll: isWindow ? 0 : this.oldScroll.x,
        contextDimension: this.innerWidth(),
        oldScroll: this.oldScroll.x,
        forward: 'right',
        backward: 'left',
        offsetProp: 'left'
      },
      vertical: {
        contextOffset: isWindow ? 0 : contextOffset.top,
        contextScroll: isWindow ? 0 : this.oldScroll.y,
        contextDimension: this.innerHeight(),
        oldScroll: this.oldScroll.y,
        forward: 'down',
        backward: 'up',
        offsetProp: 'top'
      }
    }

    for (var axisKey in axes) {
      var axis = axes[axisKey]
      for (var dine_waypointKey in this.dine_waypoints[axisKey]) {
        var dine_waypoint = this.dine_waypoints[axisKey][dine_waypointKey]
        var adjustment = dine_waypoint.options.offset
        var oldTriggerPoint = dine_waypoint.triggerPoint
        var elementOffset = 0
        var freshdineWaypoint = oldTriggerPoint == null
        var contextModifier, wasBeforeScroll, nowAfterScroll
        var triggeredBackward, triggeredForward

        if (dine_waypoint.element !== dine_waypoint.element.window) {
          elementOffset = dine_waypoint.adapter.offset()[axis.offsetProp]
        }

        if (typeof adjustment === 'function') {
          adjustment = adjustment.apply(dine_waypoint)
        }
        else if (typeof adjustment === 'string') {
          adjustment = parseFloat(adjustment)
          if (dine_waypoint.options.offset.indexOf('%') > - 1) {
            adjustment = Math.ceil(axis.contextDimension * adjustment / 100)
          }
        }

        contextModifier = axis.contextScroll - axis.contextOffset
        dine_waypoint.triggerPoint = elementOffset + contextModifier - adjustment
        wasBeforeScroll = oldTriggerPoint < axis.oldScroll
        nowAfterScroll = dine_waypoint.triggerPoint >= axis.oldScroll
        triggeredBackward = wasBeforeScroll && nowAfterScroll
        triggeredForward = !wasBeforeScroll && !nowAfterScroll

        if (!freshdineWaypoint && triggeredBackward) {
          dine_waypoint.queueTrigger(axis.backward)
          triggeredGroups[dine_waypoint.group.id] = dine_waypoint.group
        }
        else if (!freshdineWaypoint && triggeredForward) {
          dine_waypoint.queueTrigger(axis.forward)
          triggeredGroups[dine_waypoint.group.id] = dine_waypoint.group
        }
        else if (freshdineWaypoint && axis.oldScroll >= dine_waypoint.triggerPoint) {
          dine_waypoint.queueTrigger(axis.forward)
          triggeredGroups[dine_waypoint.group.id] = dine_waypoint.group
        }
      }
    }

    dineWaypoint.requestAnimationFrame(function() {
      for (var groupKey in triggeredGroups) {
        triggeredGroups[groupKey].flushTriggers()
      }
    })

    return this
  }

  /* Private */
  Context.findOrCreateByElement = function(element) {
    return Context.findByElement(element) || new Context(element)
  }

  /* Private */
  Context.refreshAll = function() {
    for (var contextId in contexts) {
      contexts[contextId].refresh()
    }
  }

  /* Public */
  /* http://imakewebthings.com/dine_waypoints/api/context-find-by-element */
  Context.findByElement = function(element) {
    return contexts[element.dine_waypointContextKey]
  }

  window.onload = function() {
    if (oldWindowLoad) {
      oldWindowLoad()
    }
    Context.refreshAll()
  }

  dineWaypoint.requestAnimationFrame = function(callback) {
    var requestFn = window.requestAnimationFrame ||
      window.mozRequestAnimationFrame ||
      window.webkitRequestAnimationFrame ||
      requestAnimationFrameShim
    requestFn.call(window, callback)
  }
  dineWaypoint.Context = Context
}())
;(function() {
  'use strict'

  function byTriggerPoint(a, b) {
    return a.triggerPoint - b.triggerPoint
  }

  function byReverseTriggerPoint(a, b) {
    return b.triggerPoint - a.triggerPoint
  }

  var groups = {
    vertical: {},
    horizontal: {}
  }
  var dineWaypoint = window.dineWaypoint

  /* http://imakewebthings.com/dine_waypoints/api/group */
  function Group(options) {
    this.name = options.name
    this.axis = options.axis
    this.id = this.name + '-' + this.axis
    this.dine_waypoints = []
    this.clearTriggerQueues()
    groups[this.axis][this.name] = this
  }

  /* Private */
  Group.prototype.add = function(dine_waypoint) {
    this.dine_waypoints.push(dine_waypoint)
  }

  /* Private */
  Group.prototype.clearTriggerQueues = function() {
    this.triggerQueues = {
      up: [],
      down: [],
      left: [],
      right: []
    }
  }

  /* Private */
  Group.prototype.flushTriggers = function() {
    for (var direction in this.triggerQueues) {
      var dine_waypoints = this.triggerQueues[direction]
      var reverse = direction === 'up' || direction === 'left'
      dine_waypoints.sort(reverse ? byReverseTriggerPoint : byTriggerPoint)
      for (var i = 0, end = dine_waypoints.length; i < end; i += 1) {
        var dine_waypoint = dine_waypoints[i]
        if (dine_waypoint.options.continuous || i === dine_waypoints.length - 1) {
          dine_waypoint.trigger([direction])
        }
      }
    }
    this.clearTriggerQueues()
  }

  /* Private */
  Group.prototype.next = function(dine_waypoint) {
    this.dine_waypoints.sort(byTriggerPoint)
    var index = dineWaypoint.Adapter.inArray(dine_waypoint, this.dine_waypoints)
    var isLast = index === this.dine_waypoints.length - 1
    return isLast ? null : this.dine_waypoints[index + 1]
  }

  /* Private */
  Group.prototype.previous = function(dine_waypoint) {
    this.dine_waypoints.sort(byTriggerPoint)
    var index = dineWaypoint.Adapter.inArray(dine_waypoint, this.dine_waypoints)
    return index ? this.dine_waypoints[index - 1] : null
  }

  /* Private */
  Group.prototype.queueTrigger = function(dine_waypoint, direction) {
    this.triggerQueues[direction].push(dine_waypoint)
  }

  /* Private */
  Group.prototype.remove = function(dine_waypoint) {
    var index = dineWaypoint.Adapter.inArray(dine_waypoint, this.dine_waypoints)
    if (index > -1) {
      this.dine_waypoints.splice(index, 1)
    }
  }

  /* Public */
  /* http://imakewebthings.com/dine_waypoints/api/first */
  Group.prototype.first = function() {
    return this.dine_waypoints[0]
  }

  /* Public */
  /* http://imakewebthings.com/dine_waypoints/api/last */
  Group.prototype.last = function() {
    return this.dine_waypoints[this.dine_waypoints.length - 1]
  }

  /* Private */
  Group.findOrCreate = function(options) {
    return groups[options.axis][options.name] || new Group(options)
  }

  dineWaypoint.Group = Group
}())
;(function() {
  'use strict'

  var $ = window.jQuery
  var dineWaypoint = window.dineWaypoint

  function JQueryAdapter(element) {
    this.$element = $(element)
  }

  $.each([
    'innerHeight',
    'innerWidth',
    'off',
    'offset',
    'on',
    'outerHeight',
    'outerWidth',
    'scrollLeft',
    'scrollTop'
  ], function(i, method) {
    JQueryAdapter.prototype[method] = function() {
      var args = Array.prototype.slice.call(arguments)
      return this.$element[method].apply(this.$element, args)
    }
  })

  $.each([
    'extend',
    'inArray',
    'isEmptyObject'
  ], function(i, method) {
    JQueryAdapter[method] = $[method]
  })

  dineWaypoint.adapters.push({
    name: 'jquery',
    Adapter: JQueryAdapter
  })
  dineWaypoint.Adapter = JQueryAdapter
}())
;(function() {
  'use strict'

  var dineWaypoint = window.dineWaypoint

  function createExtension(framework) {
    return function() {
      var dine_waypoints = []
      var overrides = arguments[0]

      if (framework.isFunction(arguments[0])) {
        overrides = framework.extend({}, arguments[1])
        overrides.handler = arguments[0]
      }

      this.each(function() {
        var options = framework.extend({}, overrides, {
          element: this
        })
        if (typeof options.context === 'string') {
          options.context = framework(this).closest(options.context)[0]
        }
        dine_waypoints.push(new dineWaypoint(options))
      })

      return dine_waypoints
    }
  }

  if (window.jQuery) {
    window.jQuery.fn.extend({
        dine_waypoint : createExtension(window.jQuery)
    });
  }
  if (window.Zepto) {
    window.Zepto.fn.dine_waypoint = createExtension(window.Zepto)
  }
}())
;