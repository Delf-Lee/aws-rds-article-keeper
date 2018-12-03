# aws-rds-article-keeper
## AWS기반 Apache webser와 RDS를 이용한 기사 모음 구현


### 다음으로 접속!
`ssh -i "delf-ec2-cloud-computing-class.pem" ec2-user@ec2-54-186-103-66.us-west-2.compute.amazonaws.com`

# 발표 자료
---

# Cloud Computing Project
## AWS를 이용한 웹사이트 구축
### Option 5. ***Apache Web Server*** + ***RDS*** 를 이용한 구축
<br>
1292032 이상훈

---
# 초기 계획
### - 기사 제목, 내용 파싱 → html문서 자동 생성
### - 주제를 바탕으로 태깅, 라벨링해서 기사 분류
### - 날짜, 출처, 이미지 등의 요소 추가
### - 화려한 디자인
### - 제목 기반 검색기능
### - ...

---

# 초기 계획
### - ~~기사 제목, 내용 파싱 → html문서 자동 생성~~
### - ~~주제를 바탕으로 태깅, 라벨링해서 기사 분류~~
### - ~~날짜, 출처, 이미지 등의 요소 추가~~
### - ~~화려한 디자인~~
### - 제목 기반 검색기능
### - ...

---
# DB 구조
- TITLE
- URL
- 끝!
### ARTICLAS table
``` 
+-------+--------------+------+-----+---------+
| Field | Type         | Null | Key | Default |
+-------+--------------+------+-----+---------+
| ID    | int(11)      | NO   | PRI | NULL    |
| TITLE | varchar(150) | YES  |     | NULL    |
| URL   | varchar(150) | YES  |     | NULL    |
+-------+--------------+------+-----+---------+
```

---
# 페이지 구조
### `index.php`
- 메인 페이지
- 기사 목록을 보여줌
- 기사의 title을 클릭하면 기사의 원문 웹 페이지로 이동
### `form.html`
- 기사의 <u>제목</u>과 <u>URL</u>을 입력, 저장

---
### `index.php`
![](./index.png)

---
### `form.html`
![](./form.png)

---
# 페이지 동작
### `index.php` [#](https://github.com/Delf-Lee/aws-rds-article-keeper/blob/master/index.php)
1. ARTICLES 테이블 없으면 생성
2. `form.html`로부터 전달받은 기사 정보가 있다면, 테이블에 추가
3. `$serach_word`가 존재하면 검색어 기반으로 `SELECT` 수행
4. `SELECT`된 기사 목록 출력
### `form.html` [#](https://github.com/Delf-Lee/aws-rds-article-keeper/blob/master/form.html)
- form에서 받은 기사 정보를 `index.php`로 전달

---
## 검색 기능
![](./search.png)

---

## 검색 기능
``` php
$search_word = htmlentities($_GET['search']);
if(empty(trim($search_word))) {
    $result = mysqli_query($connection, "SELECT * FROM ARTICLES");
} else {
    $result = mysqli_query($connection, "SELECT * FROM ARTICLES WHERE TITLE LIKE '%".$search_word."%'");
}
```

---
# 구축 과정
1. VPC 생성
2. 웹 서버 subnet, DB subnet 생성
3. 웹 서버 instance, DB instance 생성
> 4. EC2와 DB instance 연결
> - dbinfo.inc의 DB name 매핑이 안되서 삽질.

5. 테이블 생성 및 DB접근 PHP 코드 작성
> 6. 템플릿을 이용
> - 프론트는 힘들다.
7. 검색 기능 구현

---
# 시현 및 기사 추천
### https://github.com/Delf-Lee/aws-rds-article-keeper

