/**
 * 移动引擎
 * 包含功能：匀速移动、加速移动、减速移动、先加速后减速
 * @author Shines
 */
function Mover()
{
	//常量，移动状态标记
	var SPEED_KEEP = "speed_keep"; //匀速
	var SPEED_UP = "speed_up"; //加速
	var SPEED_DOWN = "speed_down"; //减速
	var SPEED_CHANGE = "speed_change"; //变速(加速匀速减速)
	var SPEED_DOWN2 = "speed_down2"; //变速(减速匀速减速)
	var LEFT = "left"; //向左
	var RIGHT = "right"; //向右
	var CONSTANT_SPEED = 5; //默认匀速速度
	var SPEED_UP_ADD = 1; //默认加速递增量
	var EASING = 0.1; //默认减速缓系数
	var MIN_SPEED = 1; //最小速度
	
	//变速(加速匀速减速)相关参数
	var speedUpTo = 0; //加速终止位置
	var speedDownTo = 0; //减速终止位置
	var constantTo = 0; //减速开始位置
	var changeFlag = SPEED_UP; //变速(加速匀速减速)标记
	
	//移动相关参数
	var destPlace = 0; //目标位置
	var moveDirection = LEFT; //移动方向
	var timerFlag = SPEED_KEEP; //移动标记
	
	//可供设置的参数
	this.currentPlace = 0; //当前位置
	this.speed = CONSTANT_SPEED; //速度
	this.speedUpAdd = SPEED_UP_ADD; //加速递增量
	this.easing = EASING; //减速缓动系数
	this.moving = false; //是否正在移动
	
	/**
	 * 根据计时器开始移动
	 */
	this.move = function()
	{
		if (this.moving)
		{
			switch (timerFlag)
			{
				case SPEED_KEEP:
					//匀速移动
					this.moveConstant();
					break;
				case SPEED_UP:
					//加速移动
					this.moveSpeedUp();
					break;
				case SPEED_DOWN:
					//减速移动
					this.moveSpeedDown();
					break;
				case SPEED_CHANGE:
					//变速(加速匀速减速)移动
					this.moveChange();
					break;
				case SPEED_DOWN2:
					//变速(加速匀速减速)移动
					this.moveDown2();
					break;
				default: 
			}
		}
	}
	
	/**
	 * 匀速移动
	 * 若目标位置不是当前位置，则移动，否则不移动
	 * @param	value	目标位置
	 */
	this.moveTo = function(value)
	{
		if (value != this.currentPlace)
		{
			//设置目标位置，设置速度，标记匀速移动
			destPlace = value;
			timerFlag = SPEED_KEEP;
			//设置移动方向，若目标位置在当前位置的左边，则移动方向为左，否则为右
			if (destPlace < this.currentPlace)
			{
				moveDirection = LEFT;
			}
			else
			{
				moveDirection = RIGHT;
			}
			//标记开始移动，开始移动
			this.moving = true;
		}
	}
	
	/**
	 * 加速移动
	 * 若目标位置不是当前位置，则移动，否则不移动
	 * @param	value	目标位置
	 */
	this.upTo = function(value)
	{
		if (value != this.currentPlace)
		{
			//设置目标位置，设置速度，设置加速递增量，标记加速移动
			destPlace = value;
			this.speed = MIN_SPEED;
			timerFlag = SPEED_UP;
			//设置移动方向，若目标位置在当前位置的左边，则移动方向为左，否则为右
			if (destPlace < this.currentPlace)
			{
				moveDirection = LEFT;
			}
			else
			{
				moveDirection = RIGHT;
			}
			//标记开始移动，开始移动
			this.moving = true;
		}
	}
	
	/**
	 * 减速移动
	 * 设置目标位置
	 * 设置减速缓动系数
	 * 标记减速移动
	 * 标记开始移动
	 * 若目标位置不是当前位置，则开始移动，否则不移动
	 * @param	value	目标位置
	 */
	this.downTo = function(value)
	{
		if (value != this.currentPlace)
		{
			destPlace = value;
			timerFlag = SPEED_DOWN;
			this.moving = true;
		}
	}
	
	/**
	 * 变速(加速匀速减速)移动
	 * @param	aSpeedUpTo	加速终止位置
	 * @param	aConstantTo	匀速终止位置
	 * @param	aDestPlace	目标位置
	 */
	this.changeTo = function(aSpeedUpTo, aConstantTo, aDestPlace)
	{
		//设置加速终止位置、匀速终止位置、目标位置、加速递增量、减速缓动系数、初始速度、移动标记、变速(加速匀速减速)标记
		speedUpTo = aSpeedUpTo;
		constantTo = aConstantTo;
		destPlace = aDestPlace;
		this.speed = MIN_SPEED;
		timerFlag = SPEED_CHANGE;
		changeFlag = SPEED_UP;
		//设置移动方向，若目标位置在当前位置的左边，则移动方向为左，否则为右
		if (speedUpTo < this.currentPlace)
		{
			moveDirection = LEFT;
		}
		else if (speedUpTo > this.currentPlace)
		{
			moveDirection = RIGHT;
		}
		else
		{
			//若当前位置和加速终止位置相同，则判断当前位置和减速开始位置，设置速度，设置变速(加速匀速减速)标记为匀速
			this.speed = CONSTANT_SPEED;
			changeFlag = SPEED_KEEP;
			if (constantTo < this.currentPlace)
			{
				moveDirection = LEFT;
			}
			else if (constantTo > this.currentPlace)
			{
				moveDirection = RIGHT;
			}
			else
			{
				//若当前位置和减速开始位置相同，则判断当前位置和目标位置，设置速度、变速(加速匀速减速)标记为减速
				changeFlag = SPEED_DOWN;
				if (destPlace < this.currentPlace)
				{
					moveDirection = LEFT;
				}
				else if (destPlace > this.currentPlace)
				{
					moveDirection = RIGHT;
				}
				else
				{
					//若当前位置和目标位置相同，则不移动
					return;
				}
			}
		}
		//标记开始移动，开始移动
		this.moving = true;
	}
	
	this.down2To = function(aSpeedDownTo, aConstantTo, aDestPlace)
	{
		//设置加速终止位置、匀速终止位置、目标位置、加速递增量、减速缓动系数、初始速度、移动标记、变速(加速匀速减速)标记
		speedDownTo = aSpeedDownTo;
		constantTo = aConstantTo;
		destPlace = aDestPlace;
		this.speed = MIN_SPEED;
		timerFlag = SPEED_DOWN2;
		changeFlag = SPEED_DOWN;
		//设置移动方向，若目标位置在当前位置的左边，则移动方向为左，否则为右
		if (speedDownTo < this.currentPlace)
		{
			moveDirection = LEFT;
		}
		else if (speedDownTo > this.currentPlace)
		{
			moveDirection = RIGHT;
		}
		else
		{
			//若当前位置和加速终止位置相同，则判断当前位置和减速开始位置，设置速度，设置变速(加速匀速减速)标记为匀速
			this.speed = CONSTANT_SPEED;
			changeFlag = SPEED_KEEP;
			if (constantTo < this.currentPlace)
			{
				moveDirection = LEFT;
			}
			else if (constantTo > this.currentPlace)
			{
				moveDirection = RIGHT;
			}
			else
			{
				//若当前位置和减速开始位置相同，则判断当前位置和目标位置，设置速度、变速(加速匀速减速)标记为减速
				changeFlag = SPEED_DOWN2;
				if (destPlace < this.currentPlace)
				{
					moveDirection = LEFT;
				}
				else if (destPlace > this.currentPlace)
				{
					moveDirection = RIGHT;
				}
				else
				{
					//若当前位置和目标位置相同，则不移动
					return;
				}
			}
		}
		//标记开始移动，开始移动
		this.moving = true;
	}
	
	/**
	 * 计时器控制匀速移动
	 * 根据移动方向移动
	 */
	this.moveConstant = function()
	{
		switch (moveDirection)
		{
			case LEFT: 
				this.currentPlace -= this.speed;
				//若到达目标位置，则停止移动
				if (this.currentPlace <= destPlace)
				{
					this.currentPlace = destPlace;
					this.moving = false;
				}
				break;
			case RIGHT: 
				this.currentPlace += this.speed;
				//若到达目标位置，则停止移动
				if (this.currentPlace >= destPlace)
				{
					this.currentPlace = destPlace;
					this.moving = false;
				}
				break;
			default: 
		}
	}
	
	/**
	 * 计时器控制加速移动
	 * 根据移动方向移动
	 */
	this.moveSpeedUp = function()
	{
		this.speed += this.speedUpAdd;
		switch (moveDirection)
		{
			case LEFT: 
				this.currentPlace -= this.speed;
				//若到达目标位置，则停止移动
				if (this.currentPlace <= destPlace)
				{
					this.currentPlace = destPlace;
					this.moving = false;
				}
				break;
			case RIGHT: 
				this.currentPlace += this.speed;
				//若到达目标位置，则停止移动
				if (this.currentPlace >= destPlace)
				{
					this.currentPlace = destPlace;
					this.moving = false;
				}
				break;
			default: 
		}
	}
	
	/**
	 * 计时器控制减速移动
	 */
	this.moveSpeedDown = function()
	{
		//减少速度，移动位置
		this.speed = (destPlace - this.currentPlace) * this.easing;
		this.currentPlace += this.speed;
		//若到达目标位置，则停止移动
		if (Math.abs(this.currentPlace - destPlace) < MIN_SPEED)
		{
			//this.currentPlace = destPlace;
			this.moving = false;
		}
	}
	
	/**
	 * 计时器控制变速(加速匀速减速)移动
	 * 根据变速(加速匀速减速)标记移动
	 */
	this.moveChange = function()
	{
		switch (changeFlag)
		{
			case SPEED_UP: 
				//加速移动
				this.speed += this.speedUpAdd;
				//根据移动方向移动
				switch (moveDirection)
				{
					case LEFT: 
						this.currentPlace -= this.speed;
						//若到达加速终止位置，则将变速(加速匀速减速)标记设为匀速
						if (this.currentPlace <= speedUpTo)
						{
							//this.currentPlace = speedUpTo;
							changeFlag = SPEED_KEEP;
						}
						break;
					case RIGHT: 
						this.currentPlace += this.speed;
						//若到达加速终止位置，则将变速(加速匀速减速)标记设为匀速
						if (this.currentPlace >= speedUpTo)
						{
							//this.currentPlace = speedUpTo;
							changeFlag = SPEED_KEEP;
						}
						break;
					default: 
				}
				break;
			case SPEED_KEEP: 
				//匀速移动
				//根据移动方向移动
				switch (moveDirection)
				{
					case LEFT: 
						this.currentPlace -= this.speed;
						//若到达减速开始位置，则将变速(加速匀速减速)标记设为减速
						if (this.currentPlace <= constantTo)
						{
							//this.currentPlace = constantTo;
							changeFlag = SPEED_DOWN;
						}
						break;
					case RIGHT: 
						this.currentPlace += this.speed;
						//若到达减速开始位置，则将变速(加速匀速减速)标记设为减速
						if (this.currentPlace >= constantTo)
						{
							//this.currentPlace = constantTo;
							changeFlag = SPEED_DOWN;
						}
						break;
					default: 
				}
				break;
			case SPEED_DOWN: 
				//减速移动
				this.speed = (destPlace - this.currentPlace) * this.easing;
				this.currentPlace += this.speed;
				//若到达目标位置，则停止移动
				if (Math.abs(this.currentPlace - destPlace) < MIN_SPEED)
				{
					//this.currentPlace = destPlace;
					this.moving = false;
				}
				break;
			default:
		}
	}
	
	/**
	 * 计时器控制变速(加速匀速减速)移动
	 * 根据变速(加速匀速减速)标记移动
	 */
	this.moveDown2 = function()
	{
		switch (changeFlag)
		{
			case SPEED_DOWN:
				//减速移动
				this.speed = (speedDownTo - this.currentPlace) * this.easing;
				this.currentPlace += this.speed;
				//若到达目标位置，则停止移动
				if (Math.abs(this.currentPlace - speedDownTo) < MIN_SPEED)
				{
					changeFlag = SPEED_KEEP;
				}
				break;
			case SPEED_KEEP: 
				//匀速移动
				//根据移动方向移动
				switch (moveDirection)
				{
					case LEFT: 
						this.currentPlace -= this.speed;
						//若到达减速开始位置，则将变速(加速匀速减速)标记设为减速
						if (this.currentPlace <= constantTo)
						{
							this.currentPlace = constantTo;
							changeFlag = SPEED_DOWN2;
						}
						break;
					case RIGHT: 
						this.currentPlace += this.speed;
						//若到达减速开始位置，则将变速(加速匀速减速)标记设为减速
						if (this.currentPlace >= constantTo)
						{
							this.currentPlace = constantTo;
							changeFlag = SPEED_DOWN2;
						}
						break;
					default: 
				}
				break;
			case SPEED_DOWN2: 
				//减速移动
				this.speed = (destPlace - this.currentPlace) * this.easing;
				this.currentPlace += this.speed;
				//若到达目标位置，则停止移动
				if (Math.abs(this.currentPlace - destPlace) < MIN_SPEED)
				{
					//this.currentPlace = destPlace;
					this.moving = false;
				}
				break;
			default: 
		}
	}
}
