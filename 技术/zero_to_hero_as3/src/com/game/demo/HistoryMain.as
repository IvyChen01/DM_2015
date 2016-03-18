package com.game.demo
{
	import com.game.lib.events.LoadEvent;
	import com.game.lib.History;
	import com.game.lib.loading.MyLoader;
	import com.game.lib.MyButton;
	import flash.display.MovieClip;
	import flash.display.Sprite;
	import flash.events.Event;
	import flash.events.MouseEvent;
	import flash.text.TextField;
	
	/**
	 * 历史记录示例
	 * @author Shines
	 */
	public class HistoryMain extends Sprite
	{
		private var _history:History = null;
		private var _cacheTxt:TextField = null;
		private var _currentTxt:TextField = null;
		private var _backBtn:MyButton = null;
		private var _forwardBtn:MyButton = null;
		private var _newBtn:MyButton = null;
		private var _clearBtn:MyButton = null;
		
		public function HistoryMain():void
		{
			if (stage)
			{
				init();
			}
			else
			{
				addEventListener(Event.ADDED_TO_STAGE, init);
			}
		}
		
		/**
		 * 初始化
		 * @param	e
		 */
		private function init(e:Event = null):void
		{
			var myLoader:MyLoader = null;
		
			if (e != null)
			{
				removeEventListener(Event.ADDED_TO_STAGE, init);
			}
			myLoader = new MyLoader();
			myLoader.addEventListener(LoadEvent.COMPLETE, onCompleteLoad);
			myLoader.addSwf("res_demo/history.swf");
			myLoader.load();
		}
		
		private function onCompleteLoad(e:LoadEvent):void 
		{
			var mc:MovieClip = null;
			
			mc = MovieClip(MyLoader.createObject("res_demo.history.DemoMc"));
			stage.addChild(mc);
			_history = new History();
			_cacheTxt = mc["cacheTxt"];
			_currentTxt = mc["currentTxt"];
			_backBtn = new MyButton(mc["backBtn"]);
			_forwardBtn = new MyButton(mc["forwardBtn"]);
			_newBtn = new MyButton(mc["newBtn"]);
			_clearBtn = new MyButton(mc["clearBtn"]);
			checkBtnState();
			
			_backBtn.addEventListener(MouseEvent.CLICK, onClickBack);
			_forwardBtn.addEventListener(MouseEvent.CLICK, onClickForward);
			_newBtn.addEventListener(MouseEvent.CLICK, onClickNew);
			_clearBtn.addEventListener(MouseEvent.CLICK, onClickClear);
		}
		
		private function onClickBack(e:MouseEvent):void 
		{
			var str:String = "";
			
			str = _history.back();
			if (null == str)
			{
				str = "";
			}
			_currentTxt.text = str;
			checkBtnState();
		}
		
		private function onClickForward(e:MouseEvent):void 
		{
			var str:String = "";
			
			str = _history.forward();
			if (null == str)
			{
				str = "";
			}
			_currentTxt.text = str;
			checkBtnState();
		}
		
		private function onClickNew(e:MouseEvent):void 
		{
			_currentTxt.appendText(int(Math.random() * 100).toString() + " ");
			_cacheTxt.text = _currentTxt.text;
			_history.add(_currentTxt.text);
			checkBtnState();
		}
		
		private function onClickClear(e:MouseEvent):void 
		{
			_currentTxt.text = "";
			_cacheTxt.text = _currentTxt.text;
			_history.clear();
			checkBtnState();
		}
		
		private function checkBtnState():void
		{
			if (_history.isFront)
			{
				_backBtn.enabled = false;
			}
			else
			{
				_backBtn.enabled = true;
			}
			
			if (_history.isRear)
			{
				_forwardBtn.enabled = false;
			}
			else
			{
				_forwardBtn.enabled = true;
			}
			
			if (_history.isEmpty)
			{
				_clearBtn.enabled = false;
			}
			else
			{
				_clearBtn.enabled = true;
			}
		}
	}
}
