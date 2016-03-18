package com.game.lib
{
	/**
	 * A*寻路
	 * @author Shines
	 */
	public class AStar
	{
		/**
		 * 寻路
		 * @param	aMap	二维数组，0表示空位，-1表示障碍
		 * @param	aStartX	起点x坐标，中心点为左上角
		 * @param	aStartY	起点y坐标，中心点为左上角
		 * @param	aEndX	终点x坐标，中心点为左上角
		 * @param	aEndY	终点y坐标，中心点为左上角
		 * @param	aWidth	物体自身的宽度
		 * @param	aHeight	物体自身的高度
		 * @return
		 */
		public static function findWay(aMap:Array, aStartX:int, aStartY:int, aEndX:int, aEndY:int, aWidth:int = 1, aHeight:int = 1):Array
		{
			var map:Array = null;//地图
			var mapWidth:int = 0;//地图宽
			var mapHeight:int = 0;//地图高
			var wayList:Array = null;//找到的路径
			var wayLen:int = 0;//路径长度，含起点和终点
			var findList:Array = null;//查找队列
			var currentPoint:Array = null;//遍历点
			var currentX:int = 0;//遍历点的x坐标
			var currentY:int = 0;//遍历点的y坐标
			var newX:int = 0;//待移动到的x位置
			var newY:int = 0;//待移动到的y位置
			
			if (null == aMap)
			{
				return null;
			}
			map = Utils.copyData(aMap) as Array;
			mapWidth = (map[0] as Array).length;
			mapHeight = map.length;
			
			if (aStartX < 0 || aStartX > mapWidth - 1)
			{
				return null;
			}
			if (aStartY < 0 || aStartY > mapHeight - 1)
			{
				return null;
			}
			if (aEndX < 0 || aEndX > mapWidth - 1)
			{
				return null;
			}
			if (aEndY < 0 || aEndY > mapHeight - 1)
			{
				return null;
			}
			if (aStartX == aEndX && aStartY == aEndY)
			{
				return [[aStartX, aStartY]];
			}
			if (map[aEndY][aEndX] != 0)
			{
				return null;
			}
			
			map[aStartY][aStartX] = 1;
			findList = [[aStartX, aStartY]];
			//遍历地图，查找路径
			while (findList.length > 0)
			{
				//取出当前点
				currentPoint = findList.shift();
				currentX = currentPoint[0];
				currentY = currentPoint[1];
				
				//遍历当前点的八个周边格子
				//左
				newX = currentX - 1;
				newY = currentY;
				if (checkPass(map, newX, newY, aWidth, aHeight))
				{
					map[newY][newX] = map[currentY][currentX] + 1;
					//判断是否到达目标点，若到达目标点则退出循环，开始回退收集路径
					if (newX == aEndX && newY == aEndY)
					{
						wayLen = map[newY][newX];
						break;
					}
					findList.push([newX, newY]);
				}
				//右
				newX = currentX + 1;
				newY = currentY;
				if (checkPass(map, newX, newY, aWidth, aHeight))
				{
					map[newY][newX] = map[currentY][currentX] + 1;
					//判断是否到达目标点，若到达目标点则退出循环，开始回退收集路径
					if (newX == aEndX && newY == aEndY)
					{
						wayLen = map[newY][newX];
						break;
					}
					findList.push([newX, newY]);
				}
				//上
				newX = currentX;
				newY = currentY - 1;
				if (checkPass(map, newX, newY, aWidth, aHeight))
				{
					map[newY][newX] = map[currentY][currentX] + 1;
					//判断是否到达目标点，若到达目标点则退出循环，开始回退收集路径
					if (newX == aEndX && newY == aEndY)
					{
						wayLen = map[newY][newX];
						break;
					}
					findList.push([newX, newY]);
				}
				//下
				newX = currentX;
				newY = currentY + 1;
				if (checkPass(map, newX, newY, aWidth, aHeight))
				{
					map[newY][newX] = map[currentY][currentX] + 1;
					//判断是否到达目标点，若到达目标点则退出循环，开始回退收集路径
					if (newX == aEndX && newY == aEndY)
					{
						wayLen = map[newY][newX];
						break;
					}
					findList.push([newX, newY]);
				}
				//左上
				newX = currentX - 1;
				newY = currentY - 1;
				if (checkPass(map, newX, newY, aWidth, aHeight))
				{
					map[newY][newX] = map[currentY][currentX] + 1;
					//判断是否到达目标点，若到达目标点则退出循环，开始回退收集路径
					if (newX == aEndX && newY == aEndY)
					{
						wayLen = map[newY][newX];
						break;
					}
					findList.push([newX, newY]);
				}
				//右上
				newX = currentX + 1;
				newY = currentY - 1;
				if (checkPass(map, newX, newY, aWidth, aHeight))
				{
					map[newY][newX] = map[currentY][currentX] + 1;
					//判断是否到达目标点，若到达目标点则退出循环，开始回退收集路径
					if (newX == aEndX && newY == aEndY)
					{
						wayLen = map[newY][newX];
						break;
					}
					findList.push([newX, newY]);
				}
				//左下
				newX = currentX - 1;
				newY = currentY + 1;
				if (checkPass(map, newX, newY, aWidth, aHeight))
				{
					map[newY][newX] = map[currentY][currentX] + 1;
					//判断是否到达目标点，若到达目标点则退出循环，开始回退收集路径
					if (newX == aEndX && newY == aEndY)
					{
						wayLen = map[newY][newX];
						break;
					}
					findList.push([newX, newY]);
				}
				//右下
				newX = currentX + 1;
				newY = currentY + 1;
				if (checkPass(map, newX, newY, aWidth, aHeight))
				{
					map[newY][newX] = map[currentY][currentX] + 1;
					//判断是否到达目标点，若到达目标点则退出循环，开始回退收集路径
					if (newX == aEndX && newY == aEndY)
					{
						wayLen = map[newY][newX];
						break;
					}
					findList.push([newX, newY]);
				}
			}
			
			//回退收集路径
			if (wayLen > 0)
			{
				wayList = [];
				currentX = aEndX;
				currentY = aEndY;
				wayList.unshift([currentX, currentY]);
				for (var sign:int = wayLen - 1; sign >= 1; sign--)
				{
					//遍历当前点的八个周边格子
					//左
					newX = currentX - 1;
					newY = currentY;
					if (newX >= 0 && newX <= mapWidth - 1 && newY >= 0 && newY <= mapHeight - 1 && map[newY][newX] == sign)
					{
						currentX = newX;
						currentY = newY;
						wayList.unshift([currentX, currentY]);
						continue;
					}
					//右
					newX = currentX + 1;
					newY = currentY;
					if (newX >= 0 && newX <= mapWidth - 1 && newY >= 0 && newY <= mapHeight - 1 && map[newY][newX] == sign)
					{
						currentX = newX;
						currentY = newY;
						wayList.unshift([currentX, currentY]);
						continue;
					}
					//上
					newX = currentX;
					newY = currentY - 1;
					if (newX >= 0 && newX <= mapWidth - 1 && newY >= 0 && newY <= mapHeight - 1 && map[newY][newX] == sign)
					{
						currentX = newX;
						currentY = newY;
						wayList.unshift([currentX, currentY]);
						continue;
					}
					//下
					newX = currentX;
					newY = currentY + 1;
					if (newX >= 0 && newX <= mapWidth - 1 && newY >= 0 && newY <= mapHeight - 1 && map[newY][newX] == sign)
					{
						currentX = newX;
						currentY = newY;
						wayList.unshift([currentX, currentY]);
						continue;
					}
					//左上
					newX = currentX - 1;
					newY = currentY - 1;
					if (newX >= 0 && newX <= mapWidth - 1 && newY >= 0 && newY <= mapHeight - 1 && map[newY][newX] == sign)
					{
						currentX = newX;
						currentY = newY;
						wayList.unshift([currentX, currentY]);
						continue;
					}
					//右上
					newX = currentX + 1;
					newY = currentY - 1;
					if (newX >= 0 && newX <= mapWidth - 1 && newY >= 0 && newY <= mapHeight - 1 && map[newY][newX] == sign)
					{
						currentX = newX;
						currentY = newY;
						wayList.unshift([currentX, currentY]);
						continue;
					}
					//左下
					newX = currentX - 1;
					newY = currentY + 1;
					if (newX >= 0 && newX <= mapWidth - 1 && newY >= 0 && newY <= mapHeight - 1 && map[newY][newX] == sign)
					{
						currentX = newX;
						currentY = newY;
						wayList.unshift([currentX, currentY]);
						continue;
					}
					//右下
					newX = currentX + 1;
					newY = currentY + 1;
					if (newX >= 0 && newX <= mapWidth - 1 && newY >= 0 && newY <= mapHeight - 1 && map[newY][newX] == sign)
					{
						currentX = newX;
						currentY = newY;
						wayList.unshift([currentX, currentY]);
						continue;
					}
				}
			}
			
			return wayList;
		}
		
		/**
		 * 检测当前点的物体是否在合法区域内（未过边界，无障碍物）
		 * @param	aMap	地图
		 * @param	aX	当前点x坐标
		 * @param	aY	当前点y坐标
		 * @param	aWidth	物体宽度
		 * @param	aHeight	物体高度
		 * @return	在合法区域内返回true，否则返回false
		 */
		private static function checkPass(aMap:Array, aX:int, aY:int, aWidth:int = 1, aHeight:int = 1):Boolean
		{
			var mapWidth:int = (aMap[0] as Array).length;
			var mapHeight:int = aMap.length;
			var leftX:int = aX;
			var rightX:int = aX + aWidth - 1;
			var upY:int = aY;
			var downY:int = aY + aHeight - 1;
			
			//检测越界
			if (leftX < 0 || leftX > mapWidth - 1)
			{
				return false;
			}
			if (rightX < 0 || rightX > mapWidth - 1)
			{
				return false;
			}
			if (upY < 0 || upY > mapHeight - 1)
			{
				return false;
			}
			if (downY < 0 || downY > mapHeight - 1)
			{
				return false;
			}
			
			//检测是否有障碍物，或该点是否已遍历过
			for (var tempX:int = leftX; tempX <= rightX; tempX++)
			{
				if (aMap[upY][tempX] != 0)
				{
					return false;
				}
				if (aMap[downY][tempX] != 0)
				{
					return false;
				}
			}
			for (var tempY:int = upY; tempY <= downY; tempY++)
			{
				if (aMap[tempY][leftX] != 0)
				{
					return false;
				}
				if (aMap[tempY][rightX] != 0)
				{
					return false;
				}
			}
			
			return true;
		}
	}
}
