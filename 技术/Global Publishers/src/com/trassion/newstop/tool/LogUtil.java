package com.trassion.newstop.tool;

import java.io.BufferedWriter;
import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.OutputStreamWriter;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Queue;
import java.util.concurrent.ConcurrentLinkedQueue;

import com.trassion.newstop.application.NewsApplication;


import android.annotation.SuppressLint;
import android.os.Environment;
import android.util.Log;
import android.util.SparseArray;

/**
 * ��־������
 * @author fu.xie
 */
public class LogUtil {
	/**
     * �Ƿ����õ���ģʽ, ���Ϊfalse����¼�κ���־
     */
    private static final boolean ADB = true;

    /**
     * ��־����
     */
    private static final int LOG_DEGREE = Log.VERBOSE;

    /**
     * �Ƿ���Ҫ��¼��־���ļ���Ĭ����Ҫ�������־�ļ����Ƿ����������������־�ļ���ȡ����LOGFILENAME������Ŀ¼�Ƿ���ڡ�
     */
    private static boolean IS_NEED_FILELOG = true;



    /**
     * ����sd��δ׼����, ������������־����
     */
    private static final int MAX_CACHE_SIZE = 128;

    /**
     * ��ǰ���¼��־��tag
     */
    private static final String TAG = "LogUtil";

    /**
     * ��¼V������־ �ڼ�¼V������־ʱ����, �����־����Ϊ����¼��־����־�������V, ����¼��־
     * @param tag ��־tag
     * @param msg ��־��Ϣ, ֧�ֶ�̬���ο�����һ������(������־��Ϣ��+���������ִ��)
     */
    public static void v(String tag, String... msg) {
        if (ADB && LOG_DEGREE <= Log.VERBOSE) {
            String msgStr = combineLogMsg(msg);

            Log.v(tag, msgStr);

            writeLogToFile(Log.VERBOSE, tag, msgStr, null);
        }
    }

    /**
     * ��¼D������־ �ڼ�¼D������־ʱ����, �����־����Ϊ����¼��־����־�������D, ����¼��־
     * @param tag ��־tag
     * @param msg ��־��Ϣ, ֧�ֶ�̬���ο�����һ������(������־��Ϣ��+���������ִ��)
     */
    public static void d(String tag, String... msg) {
        if (ADB && LOG_DEGREE <= Log.DEBUG) {
            String msgStr = combineLogMsg(msg);

            Log.d(tag, msgStr);

            writeLogToFile(Log.DEBUG, tag, msgStr, null);
        }
    }

    /**
     * ��¼I������־ �ڼ�¼I������־ʱ����, �����־����Ϊ����¼��־����־�������I, ����¼��־
     * @param tag ��־tag
     * @param msg ��־��Ϣ, ֧�ֶ�̬���ο�����һ������(������־��Ϣ��+���������ִ��)
     */
    public static void i(String tag, String... msg) {
        if (ADB && LOG_DEGREE <= Log.INFO) {
            String msgStr = combineLogMsg(msg);

            Log.i(tag, msgStr);

            writeLogToFile(Log.INFO, tag, msgStr, null);
        }
    }

    /**
     * ��¼W������־ �ڼ�¼W������־ʱ����, �����־����Ϊ����¼��־����־�������W, ����¼��־
     * @param tag ��־tag
     * @param msg ��־��Ϣ, ֧�ֶ�̬���ο�����һ������(������־��Ϣ��+���������ִ��)
     */
    public static void w(String tag, String... msg) {
        if (ADB && LOG_DEGREE <= Log.WARN) {
            String msgStr = combineLogMsg(msg);

            Log.w(tag, msgStr);

            writeLogToFile(Log.WARN, tag, msgStr, null);
        }
    }

    /**
     * ��¼E������־ �ڼ�¼E������־ʱ����, �����־����Ϊ����¼��־����־�������E, ����¼��־
     * @param tag ��־tag
     * @param msg ��־��Ϣ, ֧�ֶ�̬���ο�����һ������(������־��Ϣ��+���������ִ��)
     */
    public static void e(String tag, String... msg) {
        if (ADB && LOG_DEGREE <= Log.ERROR) {
            String msgStr = combineLogMsg(msg);

            Log.e(tag, msgStr);

            writeLogToFile(Log.ERROR, tag, msgStr, null);
        }
    }

    /**
     * ��¼E������־ �ڼ�¼E������־ʱ����, �����־����Ϊ����¼��־����־�������E, ����¼��־
     * @param tag ��־tag
     * @param tr �쳣����
     * @param msg ��־��Ϣ, ֧�ֶ�̬���ο�����һ������(������־��Ϣ��+���������ִ��)
     
     */
    public static void e(String tag, Throwable tr, String... msg) {
        if (ADB && LOG_DEGREE <= Log.ERROR) {
            String msgStr = combineLogMsg(msg);

            Log.e(tag, msgStr, tr);

            writeLogToFile(Log.ERROR, tag, msgStr, tr);

        }
    }

    /**
     * ��װ��̬���ε��ַ��� ����̬�������ַ���ƴ�ӳ�һ���ַ���
     * @param msg ��̬����
     * @return ƴ�Ӻ���ַ���
     
     */
    private static String combineLogMsg(String... msg) {
        if (null == msg)
            return null;

        StringBuilder sb = new StringBuilder();
        for (String s : msg) {
            sb.append(s);
        }
        return sb.toString();

    }

    /**
     * ������, ��ͬ��ģ����ʹ��
     */
    private static Object lock = new Object();

    /**
     * ����¼���ļ�����־����, ��Ҫ֧��ͬ��
     */
    private static Queue<String> Logs = new ConcurrentLinkedQueue<String>();

    /**
     * ��־���������Ӧ���ַ���ǩ
     */
    private static SparseArray<String> degreeLabel = new SparseArray<String>();

    /**
     * ��ʼ����־���������Ӧ���ַ���ǩ
     */
    static {
        degreeLabel.put(Log.VERBOSE, "V");
        degreeLabel.put(Log.DEBUG, "D");
        degreeLabel.put(Log.INFO, "I");
        degreeLabel.put(Log.WARN, "W");
        degreeLabel.put(Log.ERROR, "E");
    }

    /**
     * ��¼��־���ļ� ������ó���Ҫ��¼��־���ļ�, ��Ҫ����־����ƴ�ӳ�һ����־��¼, ���ȷ��뵽����¼����־������, �����첽�̼߳�¼���ļ��С�
     * ��־��ʽ����Ϊ��yyyy-MM-dd HH:mm:ss.SSS, <D>degree, <T>tag, <M>message,
     * <E>exception info
     * @param degree ��־����
     * @param tag ��־��ǩ
     * @param msg ��־��Ϣ
     * @param tr �쳣
     
     */
    @SuppressLint("SimpleDateFormat")
	private static void writeLogToFile(int degree, String tag, String msg, Throwable tr) {
        if (IS_NEED_FILELOG) {

            StringBuffer sb = new StringBuffer();

            // ƴ��ʱ�䡢��־���𡢱�ǩ����Ϣ
            SimpleDateFormat df = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss.SSS");
            sb.append(df.format(Calendar.getInstance().getTime())).append(", <D>")
                    .append(degreeLabel.get(degree)).append(", <T>").append(tag).append(", <M>")
                    .append(msg);

            // ������쳣��Ϣ, ��Ҫƴ���쳣��Ϣ, ƴ�����еĶ�ջ��Ϣ
            if (null != tr) {
                StackTraceElement[] stacks = tr.getStackTrace();
                if (null != stacks) {
                    sb.append(", <E>").append(tr.getMessage()).append("\r\n");
                    for (int i = 0; i < stacks.length; i++) {
                        sb.append("\t\tat ").append(stacks[i].getClassName()).append(".")
                                .append(stacks[i].getMethodName()).append("(")
                                .append(stacks[i].getClassName()).append(".java").append(" ")
                                .append(stacks[i].getLineNumber()).append(")").append("\r\n");
                    }
                }
            }

            // ����־��Ϣ���ӵ�������
            Logs.add(sb.toString());

            // ֪ͨ��־�߳�д�ļ�
            synchronized (lock) {
                lock.notifyAll();
            }

            // �����־�߳�û�г�ʼ��, ��Ҫ��ʼ��������
            if (null == logThread) {
                logThread = new LogThread();
                logThread.start();
            }

            // TODO �߳������ֹ, ��Դ��λ���
        }
    }

    /**
     * ��־�ļ������������
     */
    private static BufferedWriter bw;

    /**
     * ��־�̶߳���
     */
    private static LogThread logThread = null;

    /**
     * ��־�߳��� ���ڼ�¼��־���ļ����߳���
     * 
     
     * @version [1.0.0.0, 2011-3-16]
     */
    private static class LogThread extends Thread {

        /**
         * �߳��Ƿ����еı�ʶλ, ��start�߳�ʱ��Ϊtrue, ����ֹ�߳�(halt����)ʱ��Ϊfalse
         */
        boolean isRunning = false;

        @Override
        public synchronized void start() {
            isRunning = true;

            // ������־�߳�ʱ��ʼ���ļ������
            initWriter();

            super.start();
        }

        @Override
        public void run() {
            while (isRunning) {
                String log = null;

                if (null == bw) {
                    initWriter();
                }
                // writer��ʼ�����˲ż�¼��־
                else {

                    // ѭ������־������ȡ����־, ��¼���ļ���
                    while (null != (log = Logs.poll())) {

                        try {
                            bw.write(log);
                            bw.write("\r\n");
                            bw.flush();
                        } catch (IOException e) {
                            Log.e(TAG, e.getMessage(), e);

                            // ��������쳣, ������sd��������, ���������³�ʼ�������
                            initWriter();

                        }

                    }
                }

                // ���������ж����е���־��, wait, ������־�������ʱ������
                synchronized (lock) {
                    try {
                        lock.wait();
                    } catch (InterruptedException e) {
                        Log.e(TAG, e.getMessage(), e);
                    }
                }

            }
        }

        /**
         * ��ֹ�߳�ʱ���� ������ֹ�߳�, ������״̬��Ϊfalse
         */
        @SuppressWarnings("unused")
        public synchronized void halt() {
            isRunning = false;
        }

    }

    /**
     * ��ʼ���ļ���������� ����ļ�������Ѿ���ʼ����, ��Ҫ�ȹر������, �ٴ����µ����������; ����ֱ�Ӵ���
     * 
     */
    private static void initWriter() {

        // ֻ�����������־��Ŀ
        if (Logs.size() > MAX_CACHE_SIZE) {
            Logs.clear();
        }

        // ����������ʼ����, ��Ҫ�ȹر������, �ͷ���Դ
        if (bw != null) {
            try {
                bw.close();
            } catch (IOException e) {
                Log.e(TAG, e.getMessage(), e);
            }
        }

        try {

            @SuppressWarnings("unused")
            boolean mExternalStorageAvailable = false;
            boolean mExternalStorageWriteable = false;
            String state = Environment.getExternalStorageState();

            if (Environment.MEDIA_MOUNTED.equals(state)) {
                // We can read and write the media
                mExternalStorageAvailable = mExternalStorageWriteable = true;
            } else if (Environment.MEDIA_MOUNTED_READ_ONLY.equals(state)) {
                // We can only read the media
                mExternalStorageAvailable = true;
                mExternalStorageWriteable = false;
            } else {
                // Something else is wrong. It may be one of many other states,
                // but all we need
                // to know is we can neither read nor write
                mExternalStorageAvailable = mExternalStorageWriteable = false;
            }

            if (mExternalStorageWriteable) {

                File dir = new File(NewsApplication.LOGFILE.substring(0, NewsApplication.LOGFILE.lastIndexOf("/")));
                if (!dir.exists()) {
					dir.mkdirs();
                }

                // �����ļ������
                bw = new BufferedWriter(new OutputStreamWriter(new FileOutputStream(NewsApplication.LOGFILE,
                        true), "UTF-8"));
            }
        } catch (Exception e) {
            Log.e(TAG, e.getMessage(), e);
        }

    }
}
