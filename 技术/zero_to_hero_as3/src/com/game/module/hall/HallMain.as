package com.game.module.hall
{
	import com.adobe.images.JPGEncoder;
	import com.game.core.Config;
	import com.game.core.Layer;
	import com.game.core.MyJs;
	import com.game.lib.Debug;
	import com.game.lib.events.HttpEvent;
	import com.game.lib.Http;
	import com.game.lib.loading.MyLoader;
	import com.game.lib.MyButton;
	import flash.display.Bitmap;
	import flash.display.BitmapData;
	import flash.display.Loader;
	import flash.display.LoaderInfo;
	import flash.display.MovieClip;
	import flash.events.Event;
	import flash.events.KeyboardEvent;
	import flash.events.MouseEvent;
	import flash.net.FileReference;
	import flash.net.navigateToURL;
	import flash.net.URLRequest;
	import flash.utils.ByteArray;
	
	/**
	 * 大厅模块
	 * @author Shines
	 */
	public class HallMain
	{
		private const LEFT:String = "left";
		private const RIGHT:String = "right";
		
		private var _content:MovieClip = null;//元件
		private var _editPanel:EditPanel = null;
		private var _bgSelector:BgSelector = null;
		private var _photo:Photo = null;
		private var _successDlg:SuccessDlg = null;
		private var _loadingDlg:LoadingDlg = null;
		private var _errorDlg:ErrorDlg = null;
		private var _previewCloseBtn:MyButton = null;
		private var _previewContestBtn:MyButton = null;
		private var _previewCancelBtn:MyButton = null;
		private var _selectBtn:MyButton = null;
		private var _leftUpload:MyButton = null;
		private var _rightUpload:MyButton = null;
		private var _previewBtn:MyButton = null;
		private var _contestBtn:MyButton = null;
		private var _homeBtn:MyButton = null;
		private var _rankBtn:MyButton = null;
		private var _http:Http = null;
		private var _fileRef:FileReference = null;
		private var _fileFlag:String = LEFT;
		
		private var _shareUrl:String = "";
		private var _sharePic:String = "";
		
		private var _isAddEvents:Boolean = false;//是否已添加事件
		
		private var _tip:Tip = null;
		public var _isLeftPic:Boolean = false;
		public var _isRightPic:Boolean = false;
		public var _isSetPic:Boolean = false;
		
		public function HallMain():void
		{
			_content = MovieClip(MyLoader.createObject("hall.HallMc"));
			_content.gotoAndStop(1);
			_editPanel = new EditPanel(_content["editPanel"]);
			_bgSelector = new BgSelector(_content["rightPanel"]);
			_photo = new Photo(_content["photoMc"]);
			_successDlg = new SuccessDlg(_content["successMc"]);
			_loadingDlg = new LoadingDlg(_content["loadingDlg"]);
			_errorDlg = new ErrorDlg(_content["errorDlg"]);
			_previewCloseBtn = new MyButton(_content["previewCloseBtn"]);
			_previewContestBtn = new MyButton(_content["previewContestBtn"]);
			_previewCancelBtn = new MyButton(_content["previewCancelBtn"]);
			_selectBtn = new MyButton(_content["selectBtn"]);
			_leftUpload = new MyButton(_content["leftUpload"]);
			_rightUpload = new MyButton(_content["rightUpload"]);
			_previewBtn = new MyButton(_content["previewBtn"]);
			_contestBtn = new MyButton(_content["contestBtn"]);
			_homeBtn = new MyButton(_content["homeBtn"]);
			_rankBtn = new MyButton(_content["rankBtn"]);
			_http = new Http();
			_fileRef = new FileReference();
			hidePreview();
			_photo.setBg(3);
			_homeBtn.enabled = false;
			_tip = new Tip(_content["tip"]);
			
			//Layer.stage.addEventListener(KeyboardEvent.KEY_DOWN, onKeydownStage);
		}
		
		private function onKeydownStage(e:KeyboardEvent):void 
		{
			switch (e.keyCode)
			{
				case 32:
					_tip.show("ok");
					break;
				default:
			}
		}
		
		/**
		 * 显示
		 */
		public function show():void
		{
			_content.visible = true;
			if (null == _content.parent)
			{
				Layer.ui.addChild(_content);
			}
			addEvents();
		}
		
		/**
		 * 隐藏
		 */
		public function hide():void
		{
			_content.visible = false;
			if (_content.parent != null)
			{
				_content.parent.removeChild(_content);
			}
			removeEvents();
		}
		
		/**
		 * 添加事件
		 */
		private function addEvents():void
		{
			if (!_isAddEvents)
			{
				_isAddEvents = true;
				Layer.stage.addEventListener(MouseEvent.MOUSE_MOVE, onMoveStage);
				_previewBtn.addEventListener(MouseEvent.CLICK, onClickPreview);
				_previewCloseBtn.addEventListener(MouseEvent.CLICK, onClickClosePreview);
				_previewCancelBtn.addEventListener(MouseEvent.CLICK, onClickClosePreview);
				_previewContestBtn.addEventListener(MouseEvent.CLICK, onClickContest);
				_contestBtn.addEventListener(MouseEvent.CLICK, onClickContest);
				_bgSelector.addEventListener(Event.CHANGE, onChangeBg);
				_leftUpload.addEventListener(MouseEvent.CLICK, onClickLeftUpload);
				_rightUpload.addEventListener(MouseEvent.CLICK, onClickRightUpload);
				_fileRef.addEventListener(Event.SELECT, onSelectFile);
				_fileRef.addEventListener(Event.COMPLETE, onLoadFile);
				_successDlg.addEventListener(MouseEvent.CLICK, onClickShare);
				_rankBtn.addEventListener(MouseEvent.CLICK, onClickRank);
				_editPanel.addEventListener(MouseEvent.CLICK, onClickEdit);
			}
		}
		
		/**
		 * 移除事件
		 */
		private function removeEvents():void
		{
			if (_isAddEvents)
			{
				_isAddEvents = false;
				Layer.stage.removeEventListener(MouseEvent.MOUSE_MOVE, onMoveStage);
				_previewBtn.removeEventListener(MouseEvent.CLICK, onClickPreview);
				_previewCloseBtn.removeEventListener(MouseEvent.CLICK, onClickClosePreview);
				_previewCancelBtn.removeEventListener(MouseEvent.CLICK, onClickClosePreview);
				_previewContestBtn.removeEventListener(MouseEvent.CLICK, onClickContest);
				_contestBtn.removeEventListener(MouseEvent.CLICK, onClickContest);
				_bgSelector.removeEventListener(Event.CHANGE, onChangeBg);
				_leftUpload.removeEventListener(MouseEvent.CLICK, onClickLeftUpload);
				_rightUpload.removeEventListener(MouseEvent.CLICK, onClickRightUpload);
				_fileRef.removeEventListener(Event.SELECT, onSelectFile);
				_fileRef.removeEventListener(Event.COMPLETE, onLoadFile);
				_successDlg.removeEventListener(MouseEvent.CLICK, onClickShare);
				_rankBtn.removeEventListener(MouseEvent.CLICK, onClickRank);
				_editPanel.removeEventListener(MouseEvent.CLICK, onClickEdit);
			}
		}
		
		private function onClickEdit(e:MouseEvent):void 
		{
			var bmp:Bitmap = null;
			
			bmp = Bitmap(_editPanel.getPic());
			_editPanel.hide();
			if (LEFT == _fileFlag)
			{
				_photo.setPhoto1(bmp);
				_isLeftPic = true;
			}
			else
			{
				_photo.setPhoto2(bmp);
				_isRightPic = true;
			}
			if (_isLeftPic && _isRightPic)
			{
				_isSetPic = true;
			}
		}
		
		private function onClickRank(e:MouseEvent):void 
		{
			MyJs.rank();
		}
		
		private function onClickLeftUpload(e:MouseEvent):void 
		{
			_fileFlag = LEFT;
			_fileRef.browse();
		}
		
		private function onClickRightUpload(e:MouseEvent):void 
		{
			_fileFlag = RIGHT;
			_fileRef.browse();
		}
		
		private function onSelectFile(e:Event):void 
		{
			_fileRef.load();
		}
		
		private function onLoadFile(e:Event):void 
		{
			var loader:Loader = new Loader();
			
			loader.contentLoaderInfo.addEventListener(Event.COMPLETE, onCompleteLoad);
			loader.loadBytes(ByteArray(_fileRef.data));
		}
		
		private function onCompleteLoad(e:Event):void 
		{
			var loaderInfo:LoaderInfo = LoaderInfo(e.currentTarget);
			var bmp:Bitmap = null;
			
			bmp = Bitmap(loaderInfo.content);
			_editPanel.setPic(bmp);
			_editPanel.show();
		}
		
		private function onChangeBg(e:Event):void 
		{
			_photo.setBg(_bgSelector.currentPic);
		}
		
		private function onClickContest(e:MouseEvent):void 
		{
			if (_isSetPic)
			{
				_photo.fixText();
				_loadingDlg.show();
				upload();
			}
			else
			{
				_tip.show("Upload two picture first.");
			}
		}
		
		private function upload():void
		{
			var bmpData:BitmapData = null;
			var bytes:ByteArray = null;
			var jpg:JPGEncoder = new JPGEncoder(95);
			var pic:MovieClip = null;
			
			pic = _photo.content;
			bmpData = new BitmapData(pic.width, pic.height);
			bmpData.draw(pic);
			bytes = jpg.encode(bmpData);
			_http.addEventListener(HttpEvent.COMPLETE, onCompleteHttp);
			_http.upload(Config.uploadUrl, bytes);
			Debug.log("upload");
		}
		
		private function onCompleteHttp(e:HttpEvent):void 
		{
			var res:Object = e.param;
			
			_photo.showText();
			_loadingDlg.hide();
			
			//清除已上传的图片
			_isLeftPic = false;
			_isRightPic = false;
			_isSetPic = false;
			_photo.clearPhoto();
			
			if (res != null)
			{
				switch (res["code"])
				{
					case 0:
						_successDlg.show();
						_shareUrl = res["shareUrl"];
						_sharePic = res["sharePic"];
						break;
					case 1:
						_errorDlg.setLabel("Upload Error!");
						_errorDlg.show();
						break;
					case 2:
						_errorDlg.setLabel("Upload Error!");
						_errorDlg.show();
						break;
					default:
						_errorDlg.setLabel("Upload Error!");
						_errorDlg.show();
				}
			}
		}
		
		private function onClickShare(e:MouseEvent):void 
		{
			MyJs.feed(_shareUrl, _sharePic);
		}
		
		private function onClickClosePreview(e:MouseEvent):void 
		{
			hidePreview();
		}
		
		private function onClickPreview(e:MouseEvent):void 
		{
			showPreview();
		}
		
		private function onMoveStage(e:MouseEvent):void 
		{
			if (Layer.stage.mouseX > Config.STAGE_WIDTH - 103)
			{
				_bgSelector.show();
				_selectBtn.hide();
			}
			if (Layer.stage.mouseX < Config.STAGE_WIDTH - 103)
			{
				_bgSelector.hide();
				_selectBtn.show();
			}
		}
		
		private function showPreview():void
		{
			_previewCloseBtn.show();
			_previewContestBtn.show();
			_previewCancelBtn.show();
			_leftUpload.hide();
			_rightUpload.hide();
			_previewBtn.hide();
			_contestBtn.hide();
			_photo.fixText();
		}
		
		private function hidePreview():void
		{
			_previewCloseBtn.hide();
			_previewContestBtn.hide();
			_previewCancelBtn.hide();
			_leftUpload.show();
			_rightUpload.show();
			_previewBtn.show();
			_contestBtn.show();
			_photo.showText();
		}
	}
}
