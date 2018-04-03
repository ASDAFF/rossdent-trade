;(function ()
{
	'use strict';

	BX.namespace('BX.SpotLight');

	BX.SpotLight = function (options)
	{

		this.container = null;
		this.popup = null;
		this.options = options;

		if (!BX.type.isDomNode(options.renderTo))
		{
			throw new Error("BX.SpotLight: 'renderTo' is not a DOMNode.");
		}

		this.renderTo = options.renderTo;

		if(options.top)
		{
			if (!BX.type.isNumber(options.top))
			{
				throw new Error("BX.SpotLight: 'top' is not a number.");
			}

			this.top = options.top;
		}
		else
		{
			this.top = null;
		}

		if(options.left)
		{
			if (!BX.type.isNumber(options.left))
			{
				throw new Error("BX.SpotLight: 'left' is not a number.");
			}

			this.left = options.left;
		}
		else
		{
			this.left = null;
		}

		if(options.lightMode)
		{
			if (!BX.type.isBoolean(options.lightMode))
			{
				throw new Error("BX.SpotLight: 'lightMode' is not a boolean.");
			}

			this.lightMode = options.lightMode;
		}
		else
		{
			this.lightMode = null;
		}

		if(options.remind)
		{
			if (!BX.type.isBoolean(options.remind))
			{
				throw new Error("BX.SpotLight: 'remind' is not a boolean.");
			}

			this.remind = options.remind;
		}

		options.content ? this.content = options.content : this.content = null;

	};

	BX.SpotLight.prototype =
	{

		getDomElement: function ()
		{
			return BX.pos(this.renderTo);
		},

		getPopup: function ()
		{
			if(this.popup)
			{
				return this.popup;
			}

			this.popup = new BX.PopupWindow(' ', this.container, {
				className: 'main-spot-light-popup',
				angle: {
					position: top,
					offset: 41
				},
				autoHide: true,
				overlay: true,
				content: this.content ? this.content : null,
				events: {
					onPopupClose: function ()
					{
						this.popup.destroy();
						this.container.parentNode.removeChild(this.container);
					}.bind(this)
				},
				buttons: [
					new BX.PopupWindowCustomButton( {
						text: BX.message('MAIN_SPOTLIGHT_UNDERSTAND'),
						className: 'webform-small-button webform-small-button-blue',
						events: {
							click: function(){
								this.popup.destroy();
								this.container.parentNode.removeChild(this.container);
								BX.onCustomEvent(this, "spotLightOk", [this.renderTo, this]);
							}.bind(this)
						}
					}),
					this.remind ?
					new BX.PopupWindowCustomButton({
						text : BX.message('MAIN_SPOTLIGHT_REMIND_LATER'),
						className : "main-spot-light-remind-later",
						events: {
							click: function(){
								this.popup.destroy();
								this.container.parentNode.removeChild(this.container);
								BX.onCustomEvent(this, "spotLightLater", [this.renderTo, this]);
							}.bind(this)
						}
					}) : null
				]
			});

			return this.popup;
		},

		createContainer: function ()
		{
			if(this.container)
			{
				return this.container;
			}

			this.container = BX.create('div', {
				attrs: {
					className: this.lightMode ? 'main-spot-light main-spot-light-white' : 'main-spot-light'
				},
				style: {
					top: this.top ? (this.getDomElement().top + this.top) + 'px' : this.getDomElement().top + 'px',
					left: this.left ? (this.getDomElement().left + this.left) + 'px' : this.getDomElement().left + 'px'
				},
				events: this.content ? {
					mouseenter: function ()
					{
						this.getPopup().show()
					}.bind(this)
				} : null
			});

			return this.container;
		},

		show: function()
		{
			document.body.appendChild(this.createContainer());
		}
	}
})();