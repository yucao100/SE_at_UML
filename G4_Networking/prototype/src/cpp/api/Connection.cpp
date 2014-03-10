/*
 * Connection.cpp
 *
 *  Created on: Mar 10, 2014
 *      Author: cameron
 */

#include "Connection.h"

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <string>
#include <iostream>

#include <curl/curl.h>

struct MemoryStruct {
	char *memory;
	size_t size;
};

// Source: http://curl.haxx.se/libcurl/c/getinmemory.html
static size_t WriteMemoryCallback(void *contents, size_t size, size_t nmemb,
		void *userp) {
	size_t realsize = size * nmemb;
	struct MemoryStruct *mem = (struct MemoryStruct *) userp;

	mem->memory = (char *) realloc(mem->memory, mem->size + realsize + 1);
	if (mem->memory == NULL) {
		/* out of memory! */
		printf("not enough memory (realloc returned NULL)\n");
		return 0;
	}

	memcpy(&(mem->memory[mem->size]), contents, realsize);
	mem->size += realsize;
	mem->memory[mem->size] = 0;

	return realsize;

}

Connection::Connection() {
	// TODO Auto-generated constructor stub

}

Connection::~Connection() {
	// TODO Auto-generated destructor stub
}

std::string Connection::getRequest(std::string options) {

	CURL *curl_handle;
	CURLcode res;

	struct MemoryStruct tmp;
	std::string userURL;
	std::string result;

	// Build user URL
	userURL = getURL() + "?" + options;

	std::cout << "Requesting: " << userURL << std::endl;

	// Temporary storage
	tmp.memory = (char *) malloc(1);
	tmp.size = 0;

	// Initialize curl
	curl_global_init (CURL_GLOBAL_ALL);

	// Init session
	curl_handle = curl_easy_init();

	// Set URL
	curl_easy_setopt(curl_handle, CURLOPT_URL, userURL.c_str());
	// Set callback
	curl_easy_setopt(curl_handle, CURLOPT_WRITEFUNCTION, WriteMemoryCallback);

	// Set data destination
	curl_easy_setopt(curl_handle, CURLOPT_WRITEDATA, (void *) &tmp);

	// Set user agent
	curl_easy_setopt(curl_handle, CURLOPT_USERAGENT, "libcurl-agent/1.0");

	// Perform http request
	res = curl_easy_perform(curl_handle);

	// Check for errors
	if (res != CURLE_OK) {
		std::cout << "Request status failed: " << curl_easy_strerror(res)
				<< std::endl;
	}
	// Save result
	else {
		result = tmp.memory;
	}

	// Cleanup curl handle
	curl_easy_cleanup(curl_handle);

	// Cleanup temp memory
	free(tmp.memory);

	// Cleanup libcurl
	curl_global_cleanup();

	return result;

}

const std::string& Connection::getURL() const {
	return URL;
}

void Connection::setURL(const std::string& url) {
	URL = url;
}


std::string Connection::postRequest(std::string options) {

	CURL *curl_handle;
	CURLcode res;

	struct MemoryStruct tmp;
	std::string userURL;
	std::string postData;
	std::string result;

	// Build user URL
	userURL = getURL();

	// Build post data
	postData = options;
	std::cout << "Requesting: " << userURL << std::endl;

	// Temporary storage
	tmp.memory = (char *) malloc(1);
	tmp.size = 0;

	// Initialize curl
	curl_global_init (CURL_GLOBAL_ALL);

	// Init session
	curl_handle = curl_easy_init();

	// Set URL
	curl_easy_setopt(curl_handle, CURLOPT_URL, userURL.c_str());
	// Set callback
	curl_easy_setopt(curl_handle, CURLOPT_WRITEFUNCTION, WriteMemoryCallback);
	// Set POST data
	curl_easy_setopt(curl_handle, CURLOPT_POSTFIELDS, postData.c_str());

	// Set data destination
	curl_easy_setopt(curl_handle, CURLOPT_WRITEDATA, (void *) &tmp);

	// Set user agent
	curl_easy_setopt(curl_handle, CURLOPT_USERAGENT, "libcurl-agent/1.0");

	// Perform http request
	res = curl_easy_perform(curl_handle);

	// Check for errors
	if (res != CURLE_OK) {
		std::cout << "Request status failed: " << curl_easy_strerror(res)
				<< std::endl;
	}
	// Save result
	else {
		result = tmp.memory;
	}

	// Cleanup curl handle
	curl_easy_cleanup(curl_handle);

	// Cleanup temp memory
	free(tmp.memory);

	// Cleanup libcurl
	curl_global_cleanup();

	return result;

}

std::string Connection::combinedRequest( std::string getOptions, std::string postOptions ) {

	CURL *curl_handle;
	CURLcode res;

	struct MemoryStruct tmp;
	std::string userURL;
	std::string postData;
	std::string result;

	// Build user URL
	userURL = getURL() + "?" + getOptions;

	// Build post data
	postData = postOptions;
	std::cout << "Requesting: " << userURL << std::endl;

	// Temporary storage
	tmp.memory = (char *) malloc(1);
	tmp.size = 0;

	// Initialize curl
	curl_global_init (CURL_GLOBAL_ALL);

	// Init session
	curl_handle = curl_easy_init();

	// Set URL
	curl_easy_setopt(curl_handle, CURLOPT_URL, userURL.c_str());
	// Set callback
	curl_easy_setopt(curl_handle, CURLOPT_WRITEFUNCTION, WriteMemoryCallback);
	// Set POST data
	curl_easy_setopt(curl_handle, CURLOPT_POSTFIELDS, postData.c_str());

	// Set data destination
	curl_easy_setopt(curl_handle, CURLOPT_WRITEDATA, (void *) &tmp);

	// Set user agent
	curl_easy_setopt(curl_handle, CURLOPT_USERAGENT, "libcurl-agent/1.0");

	// Perform http request
	res = curl_easy_perform(curl_handle);

	// Check for errors
	if (res != CURLE_OK) {
		std::cout << "Request status failed: " << curl_easy_strerror(res)
				<< std::endl;
	}
	// Save result
	else {
		result = tmp.memory;
	}

	// Cleanup curl handle
	curl_easy_cleanup(curl_handle);

	// Cleanup temp memory
	free(tmp.memory);

	// Cleanup libcurl
	curl_global_cleanup();

	return result;

}

