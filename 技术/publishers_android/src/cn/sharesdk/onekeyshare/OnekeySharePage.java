/*
 * 瀹樼綉鍦扮珯:http://www.mob.com
 * 鎶�湳鏀寔QQ: 4006852216
 * 瀹樻柟寰俊:ShareSDK   锛堝鏋滃彂甯冩柊鐗堟湰鐨勮瘽锛屾垜浠皢浼氱涓�椂闂撮�杩囧井淇″皢鐗堟湰鏇存柊鍐呭鎺ㄩ�缁欐偍銆傚鏋滀娇鐢ㄨ繃绋嬩腑鏈変换浣曢棶棰橈紝涔熷彲浠ラ�杩囧井淇′笌鎴戜滑鍙栧緱鑱旂郴锛屾垜浠皢浼氬湪24灏忔椂鍐呯粰浜堝洖澶嶏級
 *
 * Copyright (c) 2013骞�mob.com. All rights reserved.
 */

package cn.sharesdk.onekeyshare;

import java.util.ArrayList;
import java.util.HashMap;

import cn.sharesdk.framework.Platform;
import cn.sharesdk.framework.Platform.ShareParams;
import cn.sharesdk.framework.PlatformActionListener;

import com.mob.tools.FakeActivity;

/** 蹇嵎鍒嗕韩鐨勫熀绫�*/
public class OnekeySharePage extends FakeActivity {
	private OnekeyShareThemeImpl impl;

	public OnekeySharePage(OnekeyShareThemeImpl impl) {
		this.impl = impl;
	}

	/** 鍒嗕韩鐣岄潰鏄惁寮圭獥妯″紡 */
	protected final boolean isDialogMode() {
		return impl.dialogMode;
	}

	protected final HashMap<String, Object> getShareParamsMap() {
		return impl.shareParamsMap;
	}

	/** 闈欓粯鍒嗕韩寮�叧锛堟病鏈夌晫闈紝鐩存帴鍒嗕韩 锛*/
	protected final boolean isSilent() {
		return impl.silent;
	}

	protected final ArrayList<CustomerLogo> getCustomerLogos() {
		return impl.customerLogos;
	}

	protected final HashMap<String, String> getHiddenPlatforms() {
		return impl.hiddenPlatforms;
	}

	protected final PlatformActionListener getCallback() {
		return impl.callback;
	}

	protected final ShareContentCustomizeCallback getCustomizeCallback() {
		return impl.customizeCallback;
	}

	protected final boolean isDisableSSO() {
		return impl.disableSSO;
	}

	protected final void shareSilently(Platform platform) {
		impl.shareSilently(platform);
	}

	protected final ShareParams formateShareData(Platform platform) {
		if (impl.formateShareData(platform)) {
			return impl.shareDataToShareParams(platform);
		}
		return null;
	}

	protected final boolean isUseClientToShare(Platform platform) {
		return impl.isUseClientToShare(platform);
	}

}
