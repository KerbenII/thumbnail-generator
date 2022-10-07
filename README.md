# thumbnail-generator
## Instrukcja uruchomienia:
Podnosimy kontener dockera poprzez
```bash
docker-compose up --d
```
następnie wchodzimy do kontenera:
```bash
docker-compose exec thumbnail-generator-app bash
```
:warning: uzupełniamy envy danymi do S3 (.env.local i .env.test.local) :warning: .

W celu wygenerowania miniaturek dla plików znajdujących się w images wykonujemy z kontenera:
```bash
 bin/console thumbnail:generate-many ""
```
jeżeli chcemy wygenerować obrazki dla plikow znajdujących się w podkatalogu images to zamiast "" podajemy ścieżkę względną od images do pliku
(np. images/obrazki/1.jpg" przyjmie postać obrazki/1.jpg).

Nie, nie da się w tej komendzie zrobić path traversal ;)

Napisałem przykładowy test integracyjny, który można odpalić poprzez:
```bash
composer tests-thumbnail
```
Zapewne przy realnym projekcie byłby on wykonywany jako jeden z kroków CI.
