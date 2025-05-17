from requests import post
from zk import ZK, const
from dotenv import load_dotenv
import mysql.connector
from os import getenv
from time import sleep

load_dotenv('.env')

mysql_connection = mysql.connector.connect(
    host=getenv('DB_HOST'),
    port=getenv('DB_PORT'),
    user=getenv('DB_USERNAME'),
    password=getenv('DB_PASSWORD'),
    database=getenv('DB_DATABASE')
)

host = getenv('APP_URL').rstrip('/') + "/api/"

users = {}

while True:
    with mysql_connection.cursor() as cursor:
        cursor.execute("SELECT ip, port, password, branch_id, company_id, fingerprint_username, fingerprint_password FROM fingerprint_scanners")
        for scanner in cursor.fetchall():
            try:
                ip, port, password, branch_id, company_id, fingerprint_username, fingerprint_password = scanner
                cursor.execute("SELECT branch_location_latitude, branch_location_longitude from branches WHERE id = %s", (branch_id,))
                lat, long = cursor.fetchone()
                zk = ZK(ip, port=port, timeout=20, password=password, verbose=False, force_udp=False, ommit_ping=True)
                connection = zk.connect()
                connection.disable_device()
                attendances = connection.get_attendance()
                connection.clear_attendance()
                connection.enable_device()
                payload = {
                    'check_in': 1,
                    'username': fingerprint_username,
                    'password': fingerprint_password,
                    'check_in_latitude': lat,
                    'check_in_longitude': long,
                    'check_out_latitude': lat,
                    'check_out_longitude': long,
                }
                for attendance in attendances:
                    check_in_at, check_out_at = None, None
                    check_in, check_out = None, None
                    if attendance.punch:
                        check_out_at = attendance.timestamp.strftime('%H:%M:%S')
                        check_out = 1
                    else:
                        check_in_at = attendance.timestamp.strftime('%H:%M:%S')
                        check_in = 1
                    payload['user_id'] = attendance.user_id
                    payload['check_in_at'] = check_in_at
                    payload['check_out_at'] = check_out_at
                    payload['check_in'] = check_in
                    payload['check_out'] = check_out
                    response = post(host + "attendance/log", json=payload, headers={
                        'accept': 'application/json'
                    })
                    if response.status_code == 200:
                        print(f"Successfully logged attendance for {attendance.user_id} at {attendance.timestamp}, type: {'Check out' if attendance.punch else 'Check in'}" )
                    else:
                        print(f"Failed to log attendance for {attendance.user_id} at {attendance.timestamp}")
            except Exception as e:
                print(f"Something went wrong {ip}, error: {e}")
                continue

            sleep(60)

# zk = ZK('197.45.44.156', port=4370, timeout=20, password=301992, verbose=False, force_udp=True, ommit_ping=True)
# connection = zk.connect()
# for user in zk.get_users():
#     print(user)
# connection.disable_device()
# print(connection.get_attendance())
# connection.enable_device()
# connection.clear_attendance()
# for attendance in connection.live_capture():
#     if attendance is None:
#         # implement here timeout logic
#         pass
#     else:
#         print (attendance.user_id)
