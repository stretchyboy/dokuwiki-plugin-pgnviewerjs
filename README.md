dokuwiki-plugin-pgnviewer-js
============================

Dokuwiki plugin to use http://chesstempo.com/pgn-viewer.html to display chess moves

USAGE:
Can be started with no config options with a plain <pgn>

Options in a url type style name=val&name2=val2

The config options are the same as www.chesstempo.com/pgn-usage.html 
apart from pgnString which is instead entered between the <pgn> and </pgn> tags.

```
<pgn movesFormat=main_on_own_line&boardName=KvE>
[Event "Kasparov vs Evgeny"]
[Site ""]
[Date "2001.??.??"]
[Round "?"]
[White "Kasparov Garry"]
[Black "Bareev Evgeny"]
[Result "1-0"]
[WhiteElo "2838"]
[BlackElo "2719"]
[ECO "C05"]

1. e4 e6 2. d4 d5 3. Nd2 c5 4. Ngf3 Nf6 5. e5 Nfd7 6. c3 Nc6 7. Bd3 Qb6 8.
O-O g6 9. dxc5 Nxc5 10. Nb3 Nxd3 11. Qxd3 Bg7 12. Bf4 O-O 13. Qd2 Bd7 14.
Rfe1 a5 15. Bh6 a4 16. Bxg7 Kxg7 17. Nbd4 Na5 18. Rab1 Nc4 19. Qf4 Qd8 20.
h4 h6 21. Qg3 Qe7 22. Ne2 Kh7 23. Nf4 Rg8 24. Re2 Raf8 25. Rbe1 Rc8 26. Nh2
g5 27. Nh5 gxh4 28. Qh3 Rg5 29. Nf6+ Kg7 30. f4 Rg6 31. Nhg4 Rh8 32. Nh5+
Kf8 33. Ngf6 Bc6 34. Qxh4 a3 35. b3 Nb2 36. Kh2 Qc5 37. Re3 d4 38. Rg3 dxc3
39. Rxg6 fxg6 40. Nd7+ Bxd7 41. Qf6+ 1-0
</pgn>
```
