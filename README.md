# PMMP-bandAPI
네이버 밴드 open API를 쉽게 사용할 수 있도록 해주는 플러그인입니다.

# TODO
- [x] 글쓰기
- [x] Request bands
- [ ] Readme 읽기 쉽게 수정
- [ ] 글 목록 조회
- [ ] 댓글 목록 조회
- [ ] 글 예약 전송
- [ ] custom request


---
# 사용준비
1.  https://developers.band.us/develop/myapps/api/form 에서 서비스를 등록합니다. 참고로 Redirect URI은 **아무거나 입력해도** 무방합니다.
2. https://developers.band.us/develop/myapps/list 에서 방금 생성한 애플리케이션 이름을 클릭하여 API수정페이지로 이동한 후, **밴드계정 연동 버튼**을 클릭하여 연동해줍니다.
3. 이 후 표시되는 **Access Token**을 메모해둡니다.
4. 이 플러그인을 적용하고, 서버를 재시작합니다.
5. PMMP폴더 내부에 있는 plugin_data폴더에서 생성된 **bandAPI_hc폴더**에 있는 config.yml을 열어서 아래와 같이 수정합니다.
6. **token: ""** 를 아래처럼 수정해주세요.
```
token: 아까 기억해둔 Access Token입력
```
그럼 아마 아래와 비슷한 모습일겁니다. (token값은 아래 예제보단 길어요)
```
token: AAAsbasS8ibhddbauisna2dfasnZQdjsHdjs
```
7. 저장 후 서버를 재시작합니다.
# 사용방법
## 타 플러그인에서 band API접근하기
아래와 같은 방법으로 쉽게 접근할 수 있습니다.
```php
$api = $this->getServer()->getPluginManager()->getPlugin("bandAPI_hc");
```

	예제 : https://github.com/Hancho1577/PMMP-bandAPI/tree/master/example
## band key 가져오기
타 플러그인에서 아래와같이 getBands를 호출하여 band key가 포함된 json을 전달받을 수 있습니다.
```php
$api = $this->getServer()->getPluginManager()->getPlugin("bandAPI_hc");
$api->getBands();
```
참고로 서버 콘솔에 json이 출력됩니다만, 서버 로그엔 저장되지 않습니다.

아래와 비슷한 내용일텐데, "band_key" 의 값을 메모하여 기억해주세요. ( 글 작성시 사용됩니다. )  
```
{
	"result_code": 1,
	"result_data": {
		"bands" : [{
			"name" : "밴드 이름",
			"band_key" : "AzIEz54gxWeSAB_nwygZ84",
			"cover" : "http://img.band.us/111.jpg",
			"member_count" : 100
			}
		,{
            "name" : "Baseball team",
            "band_key" : "AzIEz54gxWeSAB_nwygZ95",
            "cover" : "http://img.band.us/222.jpg",
            "member_count" : 32
         }]
	}
}
```
참고로 위 예제의 band key는 AzIEz54gxWeSAB_nwygZ95입니다.

### token값 직접 지정하기
config에 입력한 token이 아닌 다른 토큰을 사용하려면 아래와 같은 방법을 사용할 수 있습니다.
```php
$api = $this->getServer()->getPluginManager()->getPlugin("bandAPI_hc");
$api->getBands("여기에 Access Token값 입력");
```
## 글 작성하기
참고로 글 작성을 위해서 위에서 구한 글을 작성하려는 밴드의 band key가 필요합니다.

writePost(글 내용, band_key, 알림 전송 여부, token(option))
```php
$api = $this->getServer()->getPluginManager()->getPlugin("bandAPI_hc");
$api->writePost("여기에 내용을\n입력하세요","여기에 band key값 입력",false); //글 작성시 알림을 전송하지 않습니다.
$api->writePost("여기에 내용을\n입력하세요","여기에 band key값 입력",true); //글 작성시 알림을 전송합니다.
```

글 작성시 특정 token 사용예제
```php
$api = $this->getServer()->getPluginManager()->getPlugin("bandAPI_hc");
$api->writePost("여기에 내용을\n입력하세요","여기에 band key값 입력",true, "AAA2drffsaSnBD9bs7vS7dvsdSdvbsQ");
```
