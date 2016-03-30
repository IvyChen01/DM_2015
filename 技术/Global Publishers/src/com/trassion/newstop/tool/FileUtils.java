package com.trassion.newstop.tool;



import java.io.BufferedOutputStream;
import java.io.Closeable;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.FilenameFilter;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.text.DecimalFormat;

import android.content.Context;
import android.graphics.Bitmap;
import android.os.Environment;
import android.os.StatFs;
import android.text.TextUtils;

/**
 * �ļ�������
 * 
 * @author chenqian
 * @date 2013-3-20 ����11:22:15
 */
public class FileUtils {
	public static final String DEFAULT_CHARSET_NAME = "UTF-8";

	/**
	 * ��ȡ�ļ��������ַ���
	 * 
	 * @param path
	 * @return
	 */
	public static String read(String path) {
		FileInputStream is = null;
		if (!TextUtils.isEmpty(path) && isExist(path)) {
			try {
				is = new FileInputStream(path);
				byte[] data = new byte[is.available()];
				is.read(data);
				return new String(data, DEFAULT_CHARSET_NAME);
			} catch (Exception e) {
			} finally {
				closeStream(is);
			}
		}
		return null;
	}

	/**
	 * �ж��ļ��Ƿ����
	 * 
	 * @param path
	 * @return
	 */
	public static boolean isExist(String path) {
		File file = new File(path);
		return file.exists();
	}

	/**
	 * �ж��ļ��Ƿ����
	 * 
	 * @param path
	 * @return
	 */
	public static boolean isExist(File file) {
		return file.exists();
	}

	/**
	 * ��url�л�ȡͼƬ������
	 * 
	 * @param url
	 * @return
	 */
	public static String getFileName(String url) {
		int index = url.lastIndexOf("/");
		String name = null;
		if (index == -1)
			return name;
		name = url.substring(index + 1);
		return name;
	}

	/**
	 * ��url�л�ȡ��׺��
	 * 
	 * @param context
	 * @param url
	 * @return
	 */
	public static String getExtensionName(String url) {
		// ��ȡ�ļ��ĺ�׺��
		int index = url.lastIndexOf('.');
		String fileEndName = null;
		if (index > 1) {
			fileEndName = url.substring(url.lastIndexOf('.') + 1);
		}
		return fileEndName;
	}

	/**
	 * �����ļ���
	 * 
	 * @return
	 */
	public static boolean createDir(String path) {
		File file = new File(path);
		boolean r = false;
		if (!file.exists()) {
			r = file.mkdirs();
		}
		return r;
	}

	/**
	 * �����ļ�
	 * 
	 * @param fileFullPath
	 * @return
	 */
	public static boolean createFile(String fileFullPath) {
		File file = new File(fileFullPath);
		boolean r = false;
		if (!file.exists()) {
			try {
				if (file.getParentFile() != null
						&& !file.getParentFile().exists()) {
					r = file.getParentFile().mkdirs();
				}
				r = file.createNewFile();
			} catch (IOException e) {
			}
		}
		return r;
	}

	/**
	 * �����ļ�
	 * 
	 * @param fileFullPath
	 * @return
	 */
	public static boolean createFile(File file) {
		boolean r = false;
		if (!file.exists()) {
			try {
				if (file.getParentFile() != null
						&& !file.getParentFile().exists()) {
					r = file.getParentFile().mkdirs();
				}
				r = file.createNewFile();
			} catch (IOException e) {
			}
		}
		return r;
	}

	/**
	 * ɾ���ļ��������ǵ����ļ����ļ���
	 * 
	 * @param fileName
	 *            ��ɾ�����ļ���
	 * @return �ļ�ɾ���ɹ�����true,���򷵻�false
	 */

	public static boolean delete(String fileName) {
		File file = new File(fileName);
		if (!file.exists()) {
			return false;
		} else {
			if (file.isFile()) {
				return deleteFile(fileName);

			} else {
				return deleteDirectory(fileName);

			}

		}

	}

	/**
	 * ��urlת�����ļ�ȫ·��
	 * 
	 * @param url
	 * @param path
	 * @return
	 */
	public static String urlToFile(String url, String path) {
		if (!TextUtils.isEmpty(url) && !TextUtils.isEmpty(path)) {
			// return path+File.separator+getFileName(url);
			return path + File.separator + url;
		}
		return null;
	}

	/**
	 * ɾ���ļ��������ǵ����ļ����ļ���
	 * 
	 * @param fileName
	 *            ��ɾ�����ļ���
	 * @param filter
	 *            ���˰���filter�ַ����ļ����ļ���
	 * @return �ļ�ɾ���ɹ�����true,���򷵻�false
	 */

	public static boolean delete(String filePath, final String filter) {
		File file = new File(filePath);
		String[] files = file.list(new FilenameFilter() {
			@Override
			public boolean accept(File dir, String filename) {
				if (filter.contains(filename)) {
					return false;
				}
				return true;
			}
		});
		if (files != null && files.length > 0) {
			for (String f : files) {
				delete(filePath + File.separator + f);
			}
		}
		return true;
	}

	/**
	 * ɾ���ļ��������ǵ����ļ����ļ���
	 * 
	 * @param fileName
	 *            ��ɾ�����ļ���
	 * @param filters
	 *            ���˵��ļ����ļ���,���ִ�Сд
	 * @return �ļ�ɾ���ɹ�����true,���򷵻�false
	 */

	public static boolean delete(final String filePath, final String... filters) {
		File file = new File(filePath);
		String[] files = file.list(new FilenameFilter() {
			@Override
			public boolean accept(File dir, String filename) {
				if (filters != null) {
					if (ArrayUtils.contains(filters, filePath + File.separator
							+ filename)) {
						return false;
					}
				}
				return true;
			}
		});
		if (files != null && files.length > 0) {
			for (String f : files) {
				delete(filePath + File.separator + f);
			}
		}
		return true;
	}

	/**
	 * ɾ�������ļ�
	 * 
	 * @param fileName
	 *            ��ɾ���ļ����ļ���
	 * @return �����ļ�ɾ���ɹ�����true,���򷵻�false
	 */
	private static boolean deleteFile(String fileName) {
		File file = new File(fileName);
		if (file.isFile() && file.exists()) {
			file.delete();
			return true;

		} else {
			return false;

		}
	}

	/**
	 * 
	 * ɾ��Ŀ¼���ļ��У��Լ�Ŀ¼�µ��ļ�
	 * 
	 * @param dir
	 *            ��ɾ��Ŀ¼���ļ�·��
	 * @return Ŀ¼ɾ���ɹ�����true,���򷵻�false
	 */
	public static boolean deleteDirectory(String dir) {
		if (!dir.endsWith(File.separator)) {// ���dir�����ļ��ָ�����β���Զ�����ļ��ָ���
			dir = dir + File.separator;
		}
		File dirFile = new File(dir);
		if (!dirFile.exists() || !dirFile.isDirectory()) {// ���dir��Ӧ���ļ������ڣ����߲���һ��Ŀ¼�����˳�
			return false;
		}
		boolean flag = true;
		File[] files = dirFile.listFiles();
		for (int i = 0; i < files.length; i++) {// ɾ�����ļ�
			if (files[i].isFile()) {
				flag = deleteFile(files[i].getAbsolutePath());
				if (!flag) {
					break;
				}
			} else {// ɾ����Ŀ¼
				flag = deleteDirectory(files[i].getAbsolutePath());
				if (!flag) {
					break;
				}
			}
		}
		if (!flag) {
			return false;

		}
		if (dirFile.delete()) {// ɾ����ǰĿ¼
			return true;

		} else {
			return false;
		}
	}

	/**
	 * �����ļ���
	 * 
	 * @return
	 */
	public static boolean createDir(File path) {
		boolean r = false;
		if (path != null && !path.exists()) {
			r = path.mkdirs();
		}
		return r;
	}

	/**
	 * �õ���Ŀ¼
	 * 
	 * @param path
	 * @return
	 */
	public static String getParentPath(String path) {
		File file = new File(path);
		return file.getParent();
	}

	/**
	 * ���ַ���д���ļ�
	 * 
	 * @param str
	 */
	public static void write(String path, byte[] str) {
		if (path != null && str != null) {
			FileOutputStream fos = null;
			try {
				fos = new FileOutputStream(path);
				fos.write(str);
			} catch (Exception e) {
			} finally {
				try {
					if (fos != null)
						fos.close();
				} catch (IOException e) {
				}
			}
		}
	}

	/**
	 * �ж�sd�ռ��С
	 * 
	 * @param sizeMb
	 *            ��Сֵ
	 * @return
	 */
	public static boolean hasSDSpace(long size) {
		if (Environment.getExternalStorageState().equals(
				Environment.MEDIA_MOUNTED)) {
			String sdcard = Environment.getExternalStorageDirectory().getPath();
			StatFs statFs = new StatFs(sdcard);
			long blockSize = statFs.getBlockSize();
			long blocks = statFs.getAvailableBlocks();
			long availableSpare = (blocks * blockSize) / (1024 * 1024);
			if (size > availableSpare) {
				return false;
			} else {
				return true;
			}
		}
		return false;
	}

	/**
	 * �ж�sd���Ƿ����
	 * 
	 * @return
	 */
	public static boolean hasSD() {
		return Environment.getExternalStorageState().equals(
				Environment.MEDIA_MOUNTED);
	}

	/**
	 * ��ȡ�洢�̵�·��
	 * 
	 * @param c
	 * @return
	 */
	public static String getPath(Context c) {
		if (Environment.getExternalStorageState().equals(
				Environment.MEDIA_MOUNTED)) {
			return Environment.getExternalStorageDirectory().getAbsolutePath();
		} else
			return c.getFilesDir().getAbsolutePath();
	}

	/**
	 * �ļ�����
	 * 
	 * @param src
	 * @param dst
	 * @throws IOException
	 */
	public static void copy(File src, File dst) throws IOException {
		if (!dst.exists())
			createFile(dst);
		InputStream in = new FileInputStream(src);
		OutputStream out = new FileOutputStream(dst);
		copyStream(in, out);
	}

	/**
	 * �ļ�����
	 * 
	 * @param src
	 * @param dst
	 * @throws IOException
	 */
	public static void copy(String src, String dst) throws IOException {
		if (!TextUtils.isEmpty(src) && isExist(src) && !TextUtils.isEmpty(dst)) {
			if (!isExist(dst))
				createFile(dst);
			InputStream in = new FileInputStream(src);
			OutputStream out = new FileOutputStream(dst);
			copyStream(in, out);
		}
	}

	/**
	 * �ַ�������
	 * 
	 * @param data
	 * @param out
	 * @throws IOException
	 * @return void
	 * @throws
	 */
	public static void copyString(String data, File dst) throws IOException {
		if (!TextUtils.isEmpty(data) && dst != null) {
			if (dst.exists())
				createFile(dst);
			copyString(data, new FileOutputStream(dst));
		}
	}

	/**
	 * �ַ�������
	 * 
	 * @param data
	 * @param out
	 * @throws IOException
	 * @return void
	 * @throws
	 */
	public static void copyString(String data, String dst) throws IOException {
		if (!TextUtils.isEmpty(data) && !TextUtils.isEmpty(dst)) {
			if (!isExist(dst))
				createFile(dst);
			copyString(data, new FileOutputStream(dst));
		}
	}

	/**
	 * �ַ�������
	 * 
	 * @param data
	 * @param out
	 * @throws IOException
	 * @return void
	 * @throws
	 */
	public static void copyString(String data, OutputStream out)
			throws IOException {
		if (!TextUtils.isEmpty(data)) {
			out.write(data.getBytes());
			out.flush();
			out.close();
		}
	}

	/**
	 * ������
	 * 
	 * @param in
	 * @param out
	 * @throws IOException
	 */
	public static void copyStream(InputStream in, OutputStream out)
			throws IOException {
		byte[] buf = new byte[1024];
		int len;
		while ((len = in.read(buf)) > 0) {
			out.write(buf, 0, len);
		}
		out.flush();
		in.close();
		out.close();
	}

	/**
	 * ������
	 * 
	 * @param in
	 * @param out
	 * @throws IOException
	 */
	public static void copyStream(InputStream in, String fileName)
			throws IOException {
		if (isExist(fileName)) {
			delete(fileName);
		} else {
			createFile(fileName);
		}
		copyStream(in, new BufferedOutputStream(new FileOutputStream(fileName)));
	}

	/**
	 * ������
	 * 
	 * @param in
	 * @param out
	 * @throws IOException
	 */
	public static void copyStream(InputStream in, File file) throws IOException {
		if (file.exists()) {
			file.delete();
		} else {
			createFile(file);
		}
		copyStream(in, new BufferedOutputStream(new FileOutputStream(file)));
	}

	/**
	 * ��ȡ�ļ��Ĵ�С
	 * 
	 * @param file
	 * @return
	 */
	public static long fileSize(String file) {
		if (TextUtils.isEmpty(file)) {
			return 0;
		}
		File f = new File(file);
		return f.exists() ? f.length() : 0;
	}

	/**
	 * ����ͼƬ��sd��
	 * 
	 * @param bm
	 *            ͼƬ
	 * @param fullFileName
	 *            �ļ�ȫ��
	 */
	public static void saveBitmapToSd(Bitmap bm, String fullFileName) {
		if (bm == null) {
			return;
		}
		File file = new File(fullFileName);
		OutputStream outStream = null;
		try {
			file.createNewFile();
			outStream = new FileOutputStream(file);
			bm.compress(Bitmap.CompressFormat.JPEG, 100, outStream);
			outStream.flush();
		} catch (Exception e) {
		} finally {
			if (outStream != null)
				closeStream(outStream);
		}
	}

	/**
	 * ����assets�µ��ļ���ָ��·��
	 * 
	 * @param context
	 * @param fileName
	 *            �ļ���
	 * @param path
	 *            �ļ�·��
	 * @throws IOException
	 */
	public static void copyAssetsData(Context context, String fileName,
			String path) throws IOException {
		String name = fileName.contains(File.separator) ? fileName
				.substring(fileName.lastIndexOf(File.separator) + 1) : fileName;
		FileUtils.copyStream(context.getAssets().open(name),
				new BufferedOutputStream(new FileOutputStream(path
						+ File.separator + fileName)));
	}

	/**
	 * �ر���
	 * 
	 * @param stream
	 */
	public static void closeStream(Closeable stream) {
		if (stream != null) {
			try {
				stream.close();
			} catch (IOException e) {
			}
		}
	}

	/**
	 * SD��Ŀ¼�б�
	 */
	private static File[] availableSdcardFile;

	public static File[] getAvailableSdcardFiles() {
		return availableSdcardFile;
	}

	static {
		File file = Environment.getExternalStorageDirectory();
		if (file != null && file.exists()) {
			String parentPath = file.getParent();
			File parentFile = new File(parentPath);
			if (parentFile.exists()) {
				availableSdcardFile = parentFile.listFiles();
			}
		} else {
			availableSdcardFile = new File[0];
		}
	}

	/**
	 * �ж�·���Ƿ����ѿ��õ�SD��Ŀ¼��ʼ��
	 * 
	 * @param sdcardPath
	 * @return
	 */
	public static boolean startsWith(String path) {
		for (int i = 0; i < availableSdcardFile.length; i++) {
			if (path.startsWith(availableSdcardFile[i].getAbsolutePath())) {
				return true;
			}
		}
		return false;
	}

	/**
	 * ��ȡ·��SD��Ŀ¼�ľ���·��
	 * 
	 * @param path
	 * @return
	 */
	public static String getSdcardPathFromPath(String path) {
		for (File sdcardFile : availableSdcardFile) {
			if (path.startsWith(sdcardFile.getAbsolutePath())) {
				return sdcardFile.getAbsolutePath();
			}
		}
		return null;
	}

	/**
	 * �滻Path �е�SD��·��
	 * 
	 * @param path
	 * @param sdcardPath
	 * @return
	 */
	public static String repleacePath(String path, String sdcardPath) {

		for (int i = 0; i < availableSdcardFile.length; i++) {
			if (!availableSdcardFile[i].getAbsolutePath().equals(sdcardPath)) {
				String newPath = path.replace(sdcardPath,
						availableSdcardFile[i].getAbsolutePath());
				File tempFile = new File(newPath);
				if (tempFile.exists()) {
					return newPath;
				}
			}
		}
		return path;
	}

	public static long getFileSizes(File f) throws Exception {// ȡ���ļ���С
		long s = 0;
		if (f.exists()) {
			FileInputStream fis = null;
			fis = new FileInputStream(f);
			s = fis.available();
		} else {
			f.createNewFile();
			System.out.println("�ļ�������");
		}
		return s;
	}

	// �ݹ�
	public static long getFileSize(File f) throws Exception// ȡ���ļ��д�С
	{
		long size = 0;
		File flist[] = f.listFiles();
		for (int i = 0; i < flist.length; i++) {
			if (flist[i].isDirectory()) {
				size = size + getFileSize(flist[i]);
			} else {
				size = size + flist[i].length();
			}
		}
		return size;
	}

	public static String FormetFileSize(long fileS) {// ת���ļ���С
		if (fileS <= 0) return "0.00B";
		DecimalFormat df = new DecimalFormat("#.00");
		String fileSizeString = "";
		if (fileS < 1024) {
			fileSizeString = df.format((double) fileS) + "B";
		} else if (fileS < 1048576) {
			fileSizeString = df.format((double) fileS / 1024) + "K";
		} else if (fileS < 1073741824) {
			fileSizeString = df.format((double) fileS / 1048576) + "M";
		} else {
			fileSizeString = df.format((double) fileS / 1073741824) + "G";
		}
		return fileSizeString;
	}

	public static long getlist(File f) {// �ݹ���ȡĿ¼�ļ�����
		long size = 0;
		File flist[] = f.listFiles();
		size = flist.length;
		for (int i = 0; i < flist.length; i++) {
			if (flist[i].isDirectory()) {
				size = size + getlist(flist[i]);
				size--;
			}
		}
		return size;

	}
}
