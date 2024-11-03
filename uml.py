# Based on the document content provided earlier, I will now generate a class diagram representing the main components and relationships within the Room Ease system.

from graphviz import Digraph

# Create a new directed graph using Graphviz
diagram = Digraph('G', filename='class_diagram_room_ease', format='png')
diagram.attr(rankdir='TB', size='8,5')

# Add classes
diagram.node('RoomEase', label='''<<TABLE BORDER="0" CELLBORDER="1" CELLSPACING="0">
<TR><TD BGCOLOR="lightgrey">RoomEase</TD></TR>
<TR><TD>- roomID</TD></TR>
<TR><TD>- calendar</TD></TR>
<TR><TD>- requestRoomService</TD></TR>
<TR><TD>- users</TD></TR>
<TR><TD>+ manageRoom()</TD></TR>
<TR><TD>+ approveRequest()</TD></TR>
</TABLE>>''')

diagram.node('User', label='''<<TABLE BORDER="0" CELLBORDER="1" CELLSPACING="0">
<TR><TD BGCOLOR="lightgrey">User</TD></TR>
<TR><TD>- userID</TD></TR>
<TR><TD>- userRole</TD></TR>
<TR><TD>+ viewRoom()</TD></TR>
<TR><TD>+ submitRequest()</TD></TR>
<TR><TD>+ cancelRequest()</TD></TR>
</TABLE>>''')

diagram.node('CalendarService', label='''<<TABLE BORDER="0" CELLBORDER="1" CELLSPACING="0">
<TR><TD BGCOLOR="lightgrey">CalendarService</TD></TR>
<TR><TD>- calendarID</TD></TR>
<TR><TD>- events</TD></TR>
<TR><TD>+ updateCalendar()</TD></TR>
<TR><TD>+ getEventDetails()</TD></TR>
</TABLE>>''')

diagram.node('EventService', label='''<<TABLE BORDER="0" CELLBORDER="1" CELLSPACING="0">
<TR><TD BGCOLOR="lightgrey">EventService</TD></TR>
<TR><TD>- eventID</TD></TR>
<TR><TD>+ getUpcomingEvents()</TD></TR>
<TR><TD>+ getOngoingEvents()</TD></TR>
</TABLE>>''')

diagram.node('RequestService', label='''<<TABLE BORDER="0" CELLBORDER="1" CELLSPACING="0">
<TR><TD BGCOLOR="lightgrey">RequestService</TD></TR>
<TR><TD>- requestID</TD></TR>
<TR><TD>- requestStatus</TD></TR>
<TR><TD>+ createRequest()</TD></TR>
<TR><TD>+ updateRequest()</TD></TR>
</TABLE>>''')

diagram.node('NotificationService', label='''<<TABLE BORDER="0" CELLBORDER="1" CELLSPACING="0">
<TR><TD BGCOLOR="lightgrey">NotificationService</TD></TR>
<TR><TD>- notificationID</TD></TR>
<TR><TD>+ sendNotification()</TD></TR>
<TR><TD>+ checkNotificationStatus()</TD></TR>
</TABLE>>''')

diagram.node('Room', label='''<<TABLE BORDER="0" CELLBORDER="1" CELLSPACING="0">
<TR><TD BGCOLOR="lightgrey">Room</TD></TR>
<TR><TD>- roomID</TD></TR>
<TR><TD>- roomStatus</TD></TR>
<TR><TD>+ checkAvailability()</TD></TR>
<TR><TD>+ updateStatus()</TD></TR>
</TABLE>>''')

# Define relationships between classes
diagram.edge('RoomEase', 'User', label='manages')
diagram.edge('RoomEase', 'Room', label='uses')
diagram.edge('RoomEase', 'CalendarService', label='integrates with')
diagram.edge('RoomEase', 'EventService', label='uses')
diagram.edge('RoomEase', 'RequestService', label='handles')
diagram.edge('RoomEase', 'NotificationService', label='integrates with')
diagram.edge('User', 'RequestService', label='interacts with')
diagram.edge('CalendarService', 'EventService', label='updates from')

# Render the diagram to a file
diagram.render('/mnt/data/class_diagram_room_ease')

import shutil
shutil.move('class_diagram_room_ease.png', '/mnt/data/class_diagram_room_ease.png')
