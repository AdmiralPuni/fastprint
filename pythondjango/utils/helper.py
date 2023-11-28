from time import time

def json_format(status, message, data):
    return {
        "status": status,
        "message": message,
        "data": data,
        "timestamp": time()
    }