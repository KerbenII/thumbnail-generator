Przyświecała mi idea modularnego monolitu.

Każdy element rozwiązania można wymienić na inny. Dla przykładu załóżmy, że chcielibyśmy wynieść generator miniaturek na inny serwer (dla przykładu do AWSowej funkcji lambdy).
W takiej sytuacji wystarczy napisać nową implementację ThumbnailApi, która skomunikuje się z nowym repozytorium i zachowa aktualne kontrakty. Dzięki temu zmiana będzie transparentna dla "klientów modułu".

W Storage rozdzieliłem Upload od Downloadu, żeby zapewnić większą swobodę konfiguracji. Póki co DownloadApi, chociaż ma już odpowiednią warstwę abstrakcji, póki co wspiera tylko lokalny filesystem, bo takie wymaganie było wystarczające.
Z Uploadem nie ma takiego problemu. Wybrana biblioteka wspiera wszystkie proponowane rozwiązania chmurowe.

Ze względu, że PHP w nowszych wersjach potrafi już kontrolować readonly propertiesa, tam gdzie nie było takiej potrzeby rezygnowałem z geterów/seterów.
