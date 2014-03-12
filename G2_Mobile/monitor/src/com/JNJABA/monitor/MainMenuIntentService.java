package com.JNJABA.monitor;

import android.app.IntentService;
import android.content.Context;
import android.content.Intent;
import android.location.Criteria;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.Bundle;

public class MainMenuIntentService extends IntentService {
	private static final String TAG = "Monitor-Service";
	private static final int FAST = 1;
	private static final int SLOW = 0;
	
	private double lastLocationLatitude;
	private double lastLocationLongitude;
	private boolean hasFallen = false;
	
	private final int UPDATE_TIME = 900000;       //15 min
	private final int UPDATE_DISTANCE = 4000000;  //Span of the continental US
	
	public MainMenuIntentService() {
		super("MainMenuIntentService");
	}

	@Override
	protected void onHandleIntent(Intent intent) {
		handleActionMonitor();
	}
	
	//Start Monitoring for fall
	private void handleActionMonitor() {
		callGPS(SLOW, false);
		if(fallDetected()) {
			callGPS(FAST, hasFallen);
			sendWarning();
			hasFallen = false;
		}
	}
	
	//Get GPS location
	//Use FAST speed if emergency is detected otherwise go SLOW
	private void callGPS(int speed, boolean emergency) {
		LocationManager locationManager = (LocationManager) this.getSystemService(Context.LOCATION_SERVICE);
		
		Criteria criteria = new Criteria();
		criteria.setCostAllowed(false);
		
		if(emergency) {
			criteria.setAccuracy(Criteria.ACCURACY_HIGH);
		}
		else {
			criteria.setAccuracy(Criteria.ACCURACY_MEDIUM);
		}
		
		String bestProvider = locationManager.getBestProvider(criteria, false);
		
		LocationListener locationListener = new LocationListener() {
			@Override
			public void onLocationChanged(Location location) {
				//Sends data to the Cloud or stores it on local database
				//makeUseOfNewLocation(location);
				/*
				 * Location is your current location
				 * store it and access it
				 */
			}

			@Override
			public void onProviderDisabled(String provider) {
			}

			@Override
			public void onProviderEnabled(String provider) {
			}

			@Override
			public void onStatusChanged(String provider, int status, Bundle extras) {
			}
		};
		
		//updates GPS every 15 minutes or when someone moves across the span of the US
		//not meant to be updated based on area traveled.
		
		if(!emergency) {
			locationManager.requestLocationUpdates(bestProvider, UPDATE_TIME, UPDATE_DISTANCE, locationListener);
		}
		else {
			locationManager.requestLocationUpdates(bestProvider, 0, 0, locationListener);
		}
		
		//I have to run it much like we ran the graphics class
		
		lastLocationLongitude = locationManager.getLastKnownLocation(bestProvider).getLongitude();
		lastLocationLatitude = locationManager.getLastKnownLocation(bestProvider).getLatitude();
	}
	
	//Sends data to Server periodically or on Emergency
	private void storeData() {
		
	}
	
	//Runs the fall detection algorithm
	private boolean fallDetected() {
		
		return false;
	}
	
	//Warns the user that a fall has been detected and if warning is not
	//promptly answered emergency numbers are called and data is sent i.e. GPS is called for loc
	private void sendWarning() {
		
	}
}
