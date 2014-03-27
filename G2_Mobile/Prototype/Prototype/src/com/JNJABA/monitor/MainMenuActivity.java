package com.JNJABA.monitor;

import android.net.Uri;
import android.os.Bundle;
import android.app.Activity;
import android.content.Intent;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;

public class MainMenuActivity extends Activity {

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_main_menu);
		
		//Intent serviceIntent = new Intent(this, MainMenuIntentService.class);
		//startService(serviceIntent);
		
		Button mHealthButton = (Button) findViewById(R.id.health_button);
		mHealthButton.setOnClickListener(new OnClickListener() {

			// Implement Health Button
			public void onClick(View v) {
				startActivity(new Intent(MainMenuActivity.this, HealthActivity.class));
			}
		});
		
		Button mProfileButton = (Button) findViewById(R.id.profile_button);
		mProfileButton.setOnClickListener(new OnClickListener() {

			// Implement Profile Button
			public void onClick(View v) {
				startActivity(new Intent(MainMenuActivity.this, ProfileActivity.class));
			}
		});
		
		Button mOptionsButton = (Button) findViewById(R.id.options_button);
		mOptionsButton.setOnClickListener(new OnClickListener() {

			// Implement options button
			public void onClick(View v) {
				startActivity(new Intent(MainMenuActivity.this, OptionsActivity.class));
			}
		});
		
		Button mEmergencyButton = (Button) findViewById(R.id.emergency_button);
		mEmergencyButton.setOnClickListener(new OnClickListener() {

			// Call Emergency number
			public void onClick(View v) {
				Intent call = new Intent(Intent.ACTION_CALL);
				call.setData(Uri.parse("tel:16178164614"));
				startActivity(call);
			}
		});
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.main_menu, menu);
		return true;
	}

}
