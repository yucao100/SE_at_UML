#include "api/Connection.h"
#include <iostream>

int main( int argc, char *argv[] ) {

	Connection conn;

	std::cout << "Example GET request:" << std::endl;

	conn.setURL("http://httpbin.org/response-headers");

	std::cout << conn.getRequest("key=val") << std::endl;
	
	std::cout << "Example POST request:" << std::endl;

	conn.setURL("http://httpbin.org/post");

	std::cout << conn.postRequest( "data1=test1&data2=test2");

	std::cout << "Example combined request" << std::endl;

	std::cout << conn.combinedRequest( "getoption=user", "data1=test1&data2=test2");


	return 0;
}
