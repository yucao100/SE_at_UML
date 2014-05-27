/*
 * Connection.h
 *
 *  Created on: Mar 10, 2014
 *      Author: cameron
 */

#ifndef CONNECTION_HPP_
#define CONNECTION_HPP_

#include <string>

class Connection {
public:

	// Initializes the URLs
	Connection();
	// Cleans up
	virtual ~Connection();

	// Get example
	std::string getRequest( std::string options );

	// Post example
	std::string postRequest( std::string options );

	// Get & Post combined example
	std::string combinedRequest( std::string getOptions, std::string postOptions );

	// Getters & Setters
	const std::string& getURL() const;
	void setURL(const std::string& url);

private:

	// URL being requested
	std::string URL;
};

#endif /* CONNECTION_H_ */
