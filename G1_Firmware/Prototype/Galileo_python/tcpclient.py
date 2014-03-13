#coding=utf8

import socket


TCP_IP = '192.168.43.1'
TCP_PORT = 6000
BUFFER_SIZE = 10

print "program start..."

s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

print "created socket..."

s.connect((TCP_IP, TCP_PORT))
print "connected..."

s.send("Test message...")
print "sent message..."

s.close()
print "closed connection."
