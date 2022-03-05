# ChaLiWhat, Chat Like Whatsapp #

## Usage ###

1. Load the source code on a HTTP Server with enabled PHP interpreter.

2. Search on browser < server root folder>/chaliwhat/source/client/home

3. Signup or login with your credentials

4. Now you can create conversations and chat with you contacts

## Source code structure and functions ##
### Client (chaliwhat/source/client/.) ###
    - log-in page
    - sign-up page
    - home page
        - conversation tab
            - search new contacts and create new conversation
            - open conversation on the chat tab
        - chat tab
            - read all messages of the chat, ordered by date and time
            - send new message in the chat
            - receive new message in realtime

### Backbone server  (chaliwhat/source/server/.) ###
    - issues jwt when logging in
    - manages jwt information
    - manages user's login
    - manages user's signup
    - creates conversation
    - creates message in conversation and sends it to the side-car service
    - sends conversation to the client
    - sends chat of conversation 

### Side-car server  (chaliwhat/source/websocket/.) ###
    - forwards new messages when created from backbone server to client using WebSocket
