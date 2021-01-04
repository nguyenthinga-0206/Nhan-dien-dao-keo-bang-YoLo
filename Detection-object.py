import cv2
import argparse
import numpy as np
import time
from datetime import datetime
import mysql.connector
import RPi.GPIO as GPIO

db_connection = mysql.connector.connect(
  host="127.0.0.1",
  user="root",
  passwd="root",
  database="do_an"
  )

GPIO.setmode(GPIO.BCM)
# GPIO.setwarnings(False)
BUZZER= 23
# buzzState = False
GPIO.setup(BUZZER, GPIO.OUT)

# GPIO.setmode(GPIO.BCM)
GPIO.setup(17, GPIO.OUT)

ap = argparse.ArgumentParser()
ap.add_argument('-c', '--config',
                help='path to yolo config file', default='yolov3-tiny.cfg')
ap.add_argument('-w', '--weights',
                help='path to yolo pre-trained weights', default='yolov3-tiny_312000.weights')
ap.add_argument('-cl', '--classes',
                help='path to text file containing class names', default='obj.names')
args = ap.parse_args()

def getOutputsNames(net):
    layersNames = net.getLayerNames()
    return [layersNames[i[0] - 1] for i in net.getUnconnectedOutLayers()]


# Darw a rectangle surrounding the object and its class name
def draw_pred(img, class_id, confidence, x, y, x_plus_w, y_plus_h):
    label = str(classes[class_id])


    color = COLORS[class_id]

    cv2.rectangle(img, (x, y), (x_plus_w, y_plus_h), color, 2)

    cv2.putText(img, label, (x - 10, y - 10), cv2.FONT_HERSHEY_SIMPLEX, 0.5, color, 2)


# Define a window to show the cam stream on it
window_title = "Camera"
#cv2.namedWindow(window_title, cv2.WINDOW_NORMAL)

# Load names classes
classes = None
with open(args.classes, 'r') as f:
    classes = [line.strip() for line in f.readlines()]
print(classes)

# Generate color for each class randomly
COLORS = np.random.uniform(0, 255, size=(len(classes), 3))

# Define network from configuration file and load the weights from the given weights file
net = cv2.dnn.readNet(args.weights, args.config)

# Define video capture for default cam
frameWidth = 500
frameHeight = 500
cap = cv2.VideoCapture(0)
dao = 0
#dem = 0
db_cursor = db_connection.cursor()
db_cursor.execute("SELECT ID FROM image WHERE ID LIKE (SELECT MAX(ID) from image)")
dem = db_cursor.fetchone()[0]
print(dem)
img_counter = 0
while cv2.waitKey(1) < 0:
    hasframe, image = cap.read()
    # image=cv2.resize(image, (620, 480))
    #image = cv2.resize(image, (frameWidth, frameHeight))
    Height, Width, channels = image.shape
    blob = cv2.dnn.blobFromImage(image, 1.0 / 255.0, (416, 416), [0, 0, 0], True, crop=False)
    Width = image.shape[1]
    Height = image.shape[0]
    net.setInput(blob)

    outs = net.forward(getOutputsNames(net))

    class_ids = []
    confidences = []
    boxes = []
    conf_threshold = 0.3
    nms_threshold = 0.5

    for out in outs:
        # print(out.shape)
        for detection in out:

            # each detection  has the form like this [center_x center_y width height obj_score class_1_score class_2_score ..]
            scores = detection[5:]  # classes scores starts from index 5
            class_id = np.argmax(scores)
            confidence = scores[class_id]

            if confidence > 0.8:
                center_x = int(detection[0] * Width)  
                center_y = int(detection[1] * Height)
                w = int(detection[2] * Width)
                h = int(detection[3] * Height)
                x = center_x - w / 2
                y = center_y - h / 2
                class_ids.append(class_id)
                confidences.append(float(confidence))
                boxes.append([x, y, w, h])

                indices = cv2.dnn.NMSBoxes(boxes, confidences, conf_threshold, nms_threshold)

                for i in indices:
                    i = i[0]
                    box = boxes[i]
                    x = box[0]
                    y = box[1]
                    w = box[2]
                    h = box[3]
                    draw_pred(image, class_ids[i], confidences[i], round(x), round(y), round(x + w), round(y + h))
		
                now = datetime.now()
                dt = now.strftime('%Y-%m-%d %H:%M:%S') #ngày giờ lưu theo trong db
                cv2.putText(image, dt, (0, 15), cv2.FONT_HERSHEY_SIMPLEX, 0.5, (255, 0, 0))
                db_cursor = db_connection.cursor()
                dem += 1
                img_name = "/var/www/html/anh/image{}.png".format(dem)  #tạo ảnh lưu ở xampp
                cv2.imwrite(img_name, image)
                print("{} written!".format(img_name))
                
                #now = datetime.now()
                #dt = now.strftime('%Y-%m-%d %H:%M:%S') #ngày giờ lưu theo trong d
                # employee_sql_query = " INSERT INTO employee (id, name, salary) VALUES (01, 'John', 10000)"
                # Execute cursor and pass query as well as student data
                db_cursor.execute("INSERT INTO image(ID, Url, Time) VALUES (%s, %s, %s) ",(dem, 'anh/image{}.png'.format(dem),dt))
                # Execute cursor and pass query of employee and data of employee
                db_connection.commit()
                
                
                print(db_cursor.rowcount, "Record Inserted1")

                 # Execute cursor and pass query of employee and data of employee
                GPIO.output(BUZZER, True)
                GPIO.output(17, 1)
                time.sleep(1)
            
            GPIO.output(BUZZER, False)
            GPIO.output(17, 0)


    # apply  non-maximum suppression algorithm on the bounding boxes

    # Put efficiency information.
    #t, _ = net.getPerfProfile()
    #label = 'time: %.2f ms' % (t * 1000.0 / cv2.getTickFrequency())
    #now = datetime.now()
    #dt = now.strftime("%d/%m/%Y %H:%M:%S")
    
    cv2.imshow(window_title, image)