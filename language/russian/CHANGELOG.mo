<?php

$lang['Version']     = 'Versiуn';
$lang['Description'] = 'Descripciуn';
$lang['changelog']   = array(

'2.9.5' => ' 29/07/10

- [Seguridad] Corregidos varios bugs de seguridad (By slave7).-
- [Seguridad] Corregidos varios bugs de seguridad (By jtsamper).-

- [Cambio] Adaptado para que sea compatible con PHP 5.3.3.-
- [Cambio] Aparecen todas las personas que aportaron algo en los crйditos del panel administrativo.-


- Vieja numeraciуn
- [Fix][Bug #5] Los sacs no coordinan los tiempos (By slave7).-

- Numeraciуn del viejo Bug Tracker (http://sourceforge.net/apps/mantisbt/xgproyect/view_all_bug_page.php)
- [Fix][Bug #0000011] Los Sacs reparten los recursos (By slave7).-
- [Fix][Bug #0000065] Todas las rondas aparecen como ganadas y a eventualmente empatan (By Nickolay).-
- [Fix][Bug #-------] La planta de fusiуn funcionaba al 100% cuando el planeta no tenнa deuterio (By slaver7)

- Nueva numeraciуn (Arctic Tracker)
- [Fix][Bug #0000002] Corregido el link que da mбs informaciуn sobre la protecciуn de novatos.-
- [Fix][Bug #0000003] Corregido el bug en la alianza que causaba problemas para redirigir al sitio de la alianza.-
- [Fix][Bug #0000004] Bug en la producciуn, produce mбs de lo que debe (By Calzon).-
- [Fix][Bug #0000005] Bug en el incremento de puntos de las tecnologнas (By Think).-
- [Fix][Bug #0000006] Bug en el Debug Log (By Green).-

',

'2.9.4' => ' 02/03/10
- [Novedad] Ahora el mercader requiere materia oscura (2500), configurable desde constants.php.-

- [Seguridad] Limitado desde la base de datos la cantidad de cupulas que pueden ser contruidas (Gracias a medel).-
- [Seguridad] Mejora de seguridad en el formulario de los misiles.-

- [Fix][Bug #0000031] Misiуn expediciуn da escuadron fantasma.-
- [Fix][Bug #0000035] Se pueden enviar misiles interplanetarios a usuarios en vacaciones (By Neurus).- 
- [Fix][Bug #0000036] Se pueden enviar misiles interplanetarios en negativo.-
- [Fix][Bug #0000037] Se puede atacar con misiles interplanetarios a usuarios fuertes y debiles (By Neurus).-
- [Fix][Bug #0000038] Luego de un error o advertencia en el envio de misiles no se vuelve a galaxia.-
- [Fix][Bug #0000039] Al colonizar con recursos estos desaparecen.-
- [Fix][Bug #0000043] En INGAME.mo hay 2 entradas iguales.-
- [Fix][Bug #0000044] Varias cupulas de protecciуn (By Neko).-
- [Fix][Bug #0000047] Error en template estadisticas.-
- [Fix][Bug #0000048] Recursos negativos.-
- [Fix][Bug #0000050] Ataques con sondas de espionaje.-
- [Fix][Bug #0000056] Error al editar usuario en el panel administrativo (By Neko).-
- [Fix][Bug #0000059] Solucionado el error que mostraba registros dobles en las estadнsticas.-
- [Fix][Bug #-------] Fallo producido al recargar la pбgina de los edificios, defensas, tecnologias y naves (By Neko).-
- [Fix][Bug #-------] Corregido un bug que no instalaba la tabla para los plugins.-
- [Fix][Bug #-------] Corregido un bug que no tenнa en cuenta a la supernova en las expediciones.-
- [Fix][Bug #-------] Corregido un bug que ocurria por tener menos deuterio que combustible a gastar (By Neko).-
- [Fix][Bug #-------] No se mostraba correctamente el mensaje de modo vacaciones (By Neko).-
- [Fix][Bug #-------] Si la cuenta estб en modo borrar y en modo vacaciones, en el overview se le da prioridad al mensaje de borrado de la cuenta.-
- [Fix][Bug #-------] Corregido un bug menor en la creaciуn de planetas (By Kloud).-
- [Fix][Bug #-------] Corregido un bug menor en el js que maneja los recursos al enviar una flota (By Neko).-

- [Cambio] Actualizados los links de soporte y reporte de bugs del overview en el panel administrativo.-
- [Cambio] Mejoras en los reportes.-
----------- Ahora en la primer ronda siempre se listan las flotas completas.-
----------- Ahora las sondas son destruidas en la primer ronda; al atacante le sale destrucciуn en la primer ronda, al defensor el reporte completo.-
----------- Ya no se duplica la primer ronda en las batallas de 2 rondas; en la primera se muestran las flotas completas y en la segunda el mensaje destruido.-
- [Cambio] Modificada la licencia para el 2010.-
',

'2.9.3' => ' 12/02/10
- [Seguridad] Mejoras de seguridad en el movimiento de recursos (By calzon).-

- [Fix][Bug #0000040] Multiplicaciуn de recicladores (By tomtom).-
- [Fix][Bug #-------] Bug que permitнa el incremento de naves en el salto cuбntico (By war4head).-

- [Cambio] Nuevamente se volvio al viejo reloj en la visiуn general.-

# Version 0.2 del panel administrativo

.- Los moderadores y operadores ya no podran:
 || Suspender administradores.
 || Crear usuarios con rango mayor al de un jugador.
 || Reiniciar universo.
 || Ejecutar consultas SQL.
 || Editar datos personales.
 || Editar/Vaciar el historial.
.- [MINOR ADD] Adherida la ID en el sistema de suspensiуn.
.- Agregado un historial en el panel administrativo, la cual custodiara los movimientos de los siguientes archivos:
 || BanPage.php
 || ErrorPage.php
 || AccountEditorPage.php
 || Moderation.php
 || QueriesPage.php
 || ResetPage.php
 || AccountDataPage.php
 || CreateNewUserPage.php
 || GlobalMessagePage.php
 || DataBaseViewPage.php
 || ConfigStatsPage.php
 || SettingsPage.php
 || SearchInDBPage.php
.- Logs protegidos con .htaccess para que nadie pueda leerlos.
.- Agregada opciуn de modo vacaciones en Datos Personales.
.- Agregado de vuelta el scrolling en el frame (No funciona en IE).
.- Pequeсo fix en la lista de mensajes.
.- Las siguientes funciones han sido reemplazadas por una redirecciуn al buscador avanzado:
 || Lista de jugadores.
 || Lista de lunas.
 || Lista de planetas.
 || Lista de usuarios conectados.
 || Lista de planetas activos.
.- Agregado al buscador avanzado:
 || Expandir / contraer.
 || Paginaciуn.
 || Nuevos filtros y tipos de bъsqueda.
.- [FIX] borrar usuarios (No borraba las colonias de la tabla xgp_planets).
.- [FIX] bugs pequeсos en el ejecutador de consultas SQL.
.- Cambios en el ADMIN.mo y traduccion completa al inglйs. (Gracias Arali)
.- Agregada nueva funciуn -> DeleteSelectedPlanet.
',

'2.9.2' => ' 01/12/09
- [Seguridad] Cerrado un agujero en la alianza que permitнa sql injection (Gracias a privatethedawn).-

- [Novedad] Implementado un nuevo sistema de Plugins v0.3 (Gracias adri93).-
- [Novedad] Ahora cuando hay muchos recursos en la cuenta de un usuario se muestra K,M,B,T,T+ en la informaciуn de cuentas del panel del admin.-
- [Novedad] Hora y fecha del servidor, en el overview, en Castellano. (Sustituir en la linea 402 el (es_ES), por el idioma deseado.).-

- [Fix][Bug varios] Fueron corregidos varios bugs menores.-
- [Fix][Bug #0000019] Famoso error en las estadнsticas provocado por una query que no era finalizada.-
- [Fix][Bug #0000020] Informaciуn de cuentas en el panel del admin.
- [Fix][Bug #-------] No se muestra bien el tiempo de estacionar en aliado en el panel del admin.-
- [Fix][Bug #-------] Corregidos varios textos (espaсol,inglйs) en el panel de administraciуn.-
- [Fix][Bug #-------] Arreglado pequeсo error en los datos mostrados en la seccion de recursos.-
- [Fix][Bug #-------] Ahora muestra correctamente la inactividad de los jugadores de tu alianza desde.-
- [Fix][Bug #-------] Al borrar un usuario se borraran todos sus planetas.-


- [Cambio] Algunas mejoras de optimizaciуn en la informaciуn de cuentas en el panel administrativo.
- [Otros]  Mejoras en el sistema de envio de flotas del FleetAjax.php
',

'2.9.1' => ' 01/11/09

- [Fix][Menor] Corregido un bug menor en el texto de los informes de espionaje que permitнa bashing.-
- [Fix][Menor] Corregido un bug menor en el texto de los reportes de combates.-
- [Fix][Menor] Corregido un bug menor que mostraba carбcteres raros en la alianza luego de editar un texto (By Neko).-
- [Fix][Menor] Corregido un bug menor que deformaba la pбgina de los mensajes al enviar mensajes muy largos (By Neko).- 
- [Fix][Menor] Correciones en algunos textos.-

Nueva numeraciуn (bug tracker)
- [Fix][Bug #0000010] No direcciona bien el ataque.-

Vieja numeraciуn
- [Fix][Bug #5] Los sacs no coordinan los tiempos.-
- [Fix][Bug #6] Los sacs no aparecen en el mismo mensajes en la visiуn general (By privatethedawn).-


- [Cambio] Ahora cuando se estan moviendo flotas no es posible abandonar un planeta (By privatethedawn).-
- [Cambio] Ahora al explorar la galaxia, si es tu propio sistema solar, no perderбs deuterio.-
- [Cambio] Nuevo panel administrativo (By Neko)
.- Nuevo skin
.- Agregado el sistema de moderaciуn.
.- FIX suspender usuario (Si el jugador ya estaba suspendido y lo suspendias de vuelta creaba 
otra tabla con los mismos datos (duplicacion)). Mejoras.
.- Reset de universo mejorado, con poder de reiniciar distintas cosas.
.- [FIX] Al resetear todo el universo: 
 || no introducia el "id_level" en la tabla de planetas.
 || dejaba al usuario como inactivo (al reiniciar nuevamente se borraban las cuentas por inactividad).
.- Opciones de lunas mejorado.
.- Agregada la creaciуn de planetas.
.- Contador de caracteres para mensajes (cntchar.js) nuevo y mejorado.
.- Agregada la opcion de "ver todos los mensajes" y un "seleccionar todo" en la lista de mensajes.
.- Agregado sistema para crear cuentas.
.- Reestructuraciуn del adminresources.php (ahora AccountEditorPage.php)
 || Agregada la ediciуn de datos personales.
 || Agregada varias opciones mбs para la ediciуn de planetas y lunas.
 || Agregada la ediciуn de oficiales.
.- Agregado un buscador avanzado.
.- Eliminado el borrado de reportes cuando se borraba un usuario, sino cuando el otro atacante o defensor queria ver
la batalla no le figuraba.
',


'2.9.0' => ' 21/10/09

- [Seguridad] Ahora es encriptada la contraseсa que se ingresa durante la actualizaciуn.- 

- [Cambio] Optimizaciуn y mejora general en el manejo de las lunas (By angelus_ira).-
- [Cambio] Mejora en el rendimiento de algunas pбginas.-
- [Cambio] Ahora al explorar la galaxia, si es tu propio sistema solar, no perderбs deuterio.-

- [Fix][Bug #122] Problemas en la actualizaciуn de los puntos.-
- [Fix][Bug #123] Bug en los reportes mostrando que se produjo un empate cuando no fue asi.-
- [Fix][Bug #124] Problemas con el phalanx.-
- [Fix][Bug #125] Bug en la lista de amigos no permite aceptar/rechazar.-
- [Fix][Bug #126] No le aparecen los reportes de ataque al defensor.-
- [Fix][Bug #127] Problema con el title de los recursos maximo en las flotas.-
',

'2.8' => ' 10/10/09

- [Seguridad] Mejora de seguridad en varias funciones y archivos.-
- [Seguridad] Mejora de seguridad y prevenciуn de nъmeros y caracteres no permitidos en el salto cuбntico (Gracias a Trojan).-

- [Novedad] El pack en inglйs se encuentra 100% traducido (Gracias war4head).-
- [Novedad] Se definieron constantes para los oficiales, asi es mбs fбcil editarlos (no lo recomiendo).-

- [cambio] Mejoras varias en el script que calcula los ataques.-
- [Cambio] Corregido un bug de seguridad al agregar recursos al envio de una flota (Gracias a MSW).-
- [Cambio] Los reportes de combate de la secciуn mensajes ahora solo muestran un link al reporte y no un resumen.-
- [Cambio] Pequeсo fix y mejora de seguridad para el phalanx y el alcance (Gracias a Trojan).-
- [Cambio] Optimizado el alcance del phalanx, reducida la carga de procesamiento (Gracias a Trojan).-
- [Cambio] Optimizados los movimientos de flotas (Gracias a Trojan).-
- [Cambio] Los recicladores valen ahora 10.000 de metal - 6.000 de cristal - 2.000 de deuterio como corresponde.-

- [Fix][Varios] Correcciуn de varios bugs menores globales.-
- [Fix][Varios] Corregidos varios bugs menores en el armado de las estadнsticas.-
- [Fix][Varios] Corregidos varios bugs menores en los movimientos de flotas y misiones.-
- [Fix][Bug #108] Coordenadas erroneas en el mensaje de reciclaje.-
- [Fix][Bug #109] Los jugadores de la lista de compaсeros aparecen siempre como desconectados.-
- [Fix][Bug #110] Duplicaciуn de recicladores al hacer multiple clicks en la galaxia.-
- [Fix][Bug #111] Jugadores inactivos y borrados no son eliminados fisicamente.-
- [Fix][Bug #112] No son actualizados los recursos del planeta de un jugador al ser atacado.-
- [Fix][Bug #113] Pequeсo bug que muestra un mensaje de error en la pagina de los sacs.-
- [Fix][Bug #114] Bug al intentar eliminar un jugador.-
- [Fix][Bug #115] Diferencia de estados entre (debil, fuerte) al enviar una flota y la galaxia.-
- [Fix][Bug #116] Bug en la misiуn de destrucciуn.-
- [Fix][Bug #117] Bug en la alianza que no descuenta los jugadores que salen de ella.-
- [Fix][Bug #118] Bug que permite ignorar las naves e investigaciones, permitiendo edificar robots, nanos y laboratorio.-
- [Fix][Bug #119] Bug en los textos de transportes.-
- [Fix][Bug #120] Bug en las batallas de una sola ronda.-
- [Fix][Bug #121] Bug en las solicitudes de la alianza.-
',

'2.7' => ' 17/09/09

- [Novedad] Sistema para ver toda la informaciуn de la cuenta de un usuario. By Neko.-
- [Novedad] SACs implementeados [BETA].-
----------- Cуdigo: MadnessRed
----------- Testeos y funcionamiento, como la adapaciуn a la 0.9a: cyberrichy
----------- Adaptaciуn a la 2.7: lucky

- [Fix][Varios] Varios bugs menores de estilo, plantillas y lenguaje reparados.-
- [Fix][Bug #93] Bug al eliminar un jugador.-
- [Fix][Bug #94] No se muestra la cantidad de flotas en el panel de administraciуn.-
- [Fix][Bug #95] Deuterio en negativo a causa de la planta de fusiуn.-
- [Fix][Bug #96] Plantillas para solicitud de amigos descolocada.-
- [Fix][Bug #97] No se muestra el estado de baneo y vacaciones en los jugadores dentro del panel de administraciуn.-
- [Fix][Bug #99] Problemas con la pбgina de busqueda mostrando demsiados resultados o no permitiendo descender en la pбgina.-
- [Fix][Bug #100] Al mandar naves de distintos tipos a colonizar vuelve el colonizador y se pierden las otras naves.-
- [Fix][Bug #101] No se generan lunas cuando sale un 20% de probabilidad.-
- [Fix][Bug #102] Al salir de una alianza el nъmero de miembros no disminuye como deberнa.-
- [Fix][Bug #103] Problemas al actualizar las estadнsticas.-
- [Fix][Bug #104] Cuando construis nanobots o robots te permite hacer naves y defensas.-
- [Fix][Bug #105] Bug menor en la alianza la querer editar el rango de un usuario cuando no existen rangos.-
- [Fix][Bug #106] Se encuentran invertidas las temperaturas de las lunas.-
- [Fix][Bug #107] Los planetas destruidos son contados como planetas activos.-
',

'2.6' => ' 24/08/09

- [Fix][Varios] Varios bugs menores de estilo, plantillas y lenguaje reparados.-
- [Fix][Bug #28] Bug en la cola de produccion del hangar.-
- [Fix][Bug #73] Problemas con el reporte de porcetaje de luna.-
- [Fix][Bug #78] Problemas con la lista de construcciуn.-
- [Fix][Bug #82] Se pueden mover flotas desde la galaxia cuando un jugador esta en modo vacaciones.-
- [Fix][Bug #83] Los reportes de ataque muy largos no se pueden ver completos.-
- [Fix][Bug #85] La cantidad de recursos para construir siempre se queda en rojo.-
- [Fix][Bug #84] Si la luna esta llena, no te permite desmontar edificios.-
- [Fix][Bug #86] Bug que provoca errores en las alianzas.-
- [Fix][Bug #87] Bug en el estilo del panel de administraciуn, mostrando imagenes del juego.-
- [Fix][Bug #88] Bug menor que muestra un texto que fue utilizado para debug.-
- [Fix][Bug #89] Bug que permite la ampliacion del hangar cuando se estan construyendo flotas y defensas.-
- [Fix][Bug #90] Problemas con la misiуn de destrucciуn.-
- [Fix][Bug #91] No funciona correctamente el almirante.-
- [Fix][Bug #92] No funciona correctamente el almacenista.-

- [Cambio] Ahora la lista de planetas se muestra en el panel de admnistraciуn por id de menor a mayor.-
',

'2.5' => ' 18/08/09

- [Novedad] Sistema de advertencias y errores en el panel de administraciуn (tambiйn informa la existencia de una nueva versiуn).-
- [Novedad] Ahora puedes determinar si al banear un jugador este debe entrar o no en modo vacaciones.-
- [Novedad] Gracias a 3R1K que tradujo el panel de administraciуn en su totalidad al idioma inglйs.-
- [Novedad] Rediseсado el panel de administraciуn.-
- [Novedad] Ahora la pбgina de mensajes respeta el formato del OGame original, mostrando a los operadores del juego.- 
- [Novedad] Ahora cuando borras un planeta aparece planeta destruido como en el OGame original.-
- [Novedad] El misil interplanetario ahora requiere el hangar en nivel 1 y el motor de impulso en 1 como en el OGame original.-
- [Novedad] El misil de intercepciуn ahora requiere el hangar en nivel 1 como en el OGame original.-
- [Novedad] El silo ahora requiere el hangar en nivel 1 como en el OGame original.-

- [Fix][Varios] Varios bugs menores de estilo, plantillas y lenguaje reparados.-
- [Fix][Bug #14] No se pueden usar skins externos.-
- [Fix][Bug #47] Bug que provoca en IE que no se vea el menu y quede desplazado hacia arriba al bajar demasiado en una pбgina.-
- [Fix][Bug #61] Problemas en el conteo de los jugadores en la visiуn general.-
- [Fix][Bug #62] Pequeсo bug que no muestra los stats correctamente en el overview.-
- [Fix][Bug #63] Bug en la funciуn del manejo de las sesiones.-
- [Fix][Bug #64] Bug con los permisos y con las lunas, evitando que sean atacadas.-
- [Fix][Bug #65] Bug que no permite espiar desde flota pero si desde la galaxia.-
- [Fix][Bug #66] Problemas en los niveles del phalanx.-
- [Fix][Bug #67] Producciуn ilimitada de misiles.-
- [Fix][Bug #68] Bug en el link para Continuar/Volver luego de enviar un mensaje circular en la alianza.-
- [Fix][Bug #69] Bug que muestra mal los mensajes de error cuando un usuario no esta logueado.-
- [Fix][Bug #70] Problemas con el salto de lнnea en los mensajes circulares.-
- [Fix][Bug #71] Problemas con la misiуn estacionar aliado, muestra un mensaje de que el jugador es muy fuerte.-
- [Fix][Bug #72] Bug en la diferencia de energнa consumida actual, anterior y posterior.-
- [Fix][Bug #74] No se puede abandonar la alianza.-
- [Fix][Bug #75] Problemas en la actualizaciуn de puntos de algunos jugadores.-
- [Fix][Bug #76] La misiуn de espionaje ignora el estado de vacaciones desde la visiуn de galaxia.-
- [Fix][Bug #77] Al hacer regresar una flota con misiуn mantener posiciуn no descuenta los tiempos correctamente.-
- [Fix][Bug #79] Bug que permite incrementar las tecnologнas (Gracias a mikey302 y death).-
- [Fix][Bug #80] Bug en el limite de envio mбximo de expediciones.-
- [Fix][Bug #81] Bug en la visiуn general de la alianza, mantiene el nombre "Fundador" del fundador de la alianza.-

- [Cambio] Ahora el nъmero de la versiуn se obtiene de la base de datos.-
- [Cambio] Mejoras de seguridad en la pбgina de la alianza.-
- [Cambio] Noticias removidas.-
- [Cambio] Mejorada la velocidad en que se genera la pбgina de estadнsticas y algunos cambios menores.-
- [Cambio] Nuevas alertas de presencia del directorio install y de escritura del archivo config.php.-
- [Cambio] Los recicladores ahora sуlo pueden transportar 20.000 unidades de recursos como en el OGame original.-
- [Cambio] Removida la pбgina de contacto, ahora puedes encontrar a los adms/mods/oper en el panel de mensajes como en el OGame.-
- [Cambio] Ahora a la derecha del nombre de la luna aparece la referencia (Luna) como en el OGame original.-
- [Cambio] Ahora si en la visiуn general tienes seleccionada la luna no se mostrarб esta otra vez a la izquierda.-
- [Cambio] Reformas en la galaxia en cуdigo y organizaciуn de las clases y plantillas.-
- [Cambio] Juego adaptado al skin original del OGame, ahora el juego serб a su vez compatible con cualquier skin.-
',


'2.4' => ' 25/07/09

- [Seguridad] Protecciуn con .htaccess de la carpeta includes, language y templates.-
- [Seguridad] Protecciуn con .htaccess de common.php, config.php y extension.inc.php.-
- [Seguridad] Cambio en el protecciуn de carpetas.-
- [Seguridad] Mejoras de seguridad en diversos archivos.-

- [Novedad] Nuevo sistema de estadнsticas, mбs rбpido, mбs simple, menos querys, menos carga, y nuevo panel para administrarlas; (By angelus_ira) Muchas gracias =) .-
- [Novedad] Nuevo sistema de idioma, ahora el idioma es configurable desde el panel de administraciуn, seleccionando un lenguaje a la vez.-
- [Novedad] La tecnologнa de espionaje funciona como en el ogame original:
-------- Nivel 0 a 1 -> Sin datos de la flota.-
-------- Nivel 2 a 3 -> Nъmero total de naves.-
-------- Nivel 4 a 7 -> Nъmero total de naves y el tipo de las naves.-
-------- Nivel 8 -> Nъmero total de naves, tipo de nave y cantidad de cada tipo.-

- [Novedad] Ahora el administrador puede decidir si los administradores y/o moderadores se les actualizarбn o no los puntos.-
- [Novedad] Ahora el administrador puede decidir si los administradores y/o moderadores pueden o no recibir ataques de otros jugadores.-
- [Novedad] Ahora en las investigaciones te muestra el nivel de espionaje y computaciуn que te dan los comandantes.-
- [Novedad] Cuando un usuario es baneado, ahora le muestra la fecha en que finaliza su ban.-

- [Fix][Varios] Corregidos varios bugs menores de redirecciуn, visuales, textos y configuraciones.-
- [Fix][Bug #1] Al achicar la pantalla se superpone el menu de recursos con el resto del cuerpo.-
- [Fix][Bug #2] Ahora cuando una cuenta es baneada, el jugador baneado no podrб acceder a la cuenta de ningun forma.-
- [Fix][Bug #3]	Al borrar una luna, ya no borrarб el planeta.-
- [Fix][Bug #4] Reparados algunos bugs en el phalanx.-
- [Fix][Bug #8] Corregida la visiуn del imperio, ahora muestra las investigaciones.-
- [Fix][Bug #9] Ahora al cerrar el servidor un usuario comъn no podrб ingresar.-
- [Fix][Bug #10] Problemas en los permisos de las alianzas.-
- [Fix][Bug #11] Ahora al cerrar el servidor no desaparece mбs el mensaje con el motivo para cerrarlo.-
- [Fix][Bug #12] Ahora la misiуn desplegar funciona correctamente.-
- [Fix][Bug #13] La misiуn estacionar en aliado funciona correctamente, no se repiten mбs mensajes, ni tampoco produce tiempos negativos cuando se selecciona como tiempo de estacionamiento 0 horas.-
- [Fix][Bug #15] Problemas con la misiуn de recoleccion o reciclaje, no entrega los recursos a quien corresponde.-
- [Fix][Bug #16] Problemas con los tiempos del hangar al cambiar de planeta, volviendo el tiempo a su estado incial.-
- [Fix][Bug #17] Los oficiales almirante y general funcionan correctamente [oficiales al 100%].-
- [Fix][Bug #18] Problemas con la planta en nivel 1 permitiendo la produccion de recursos (Fixed by zorro2666).-
- [Fix][Bug #19] Ahora si un jugador es fuerte o dйbil y al mismo tiempo estб inactivo podrб ser atacado de todas formas.-
- [Fix][Bug #20] Problemas de caracteres en los textos de registro.-
- [Fix][Bug #21] No funciona el enviar mensaje cuando recibes un ataque.-
- [Fix][Bug #22] Problemas con los mensajes al redactar un mensaje privado en la parte visual.-
- [Fix][Bug #23] Fallan los links que redirigen a la galaxia durante los movimientos de flotas.-
- [Fix][Bug #24] El hangar permite producir igual durante su ampliaciуn (Fixed by zorro2666).-
- [Fix][Bug #25] Se puede ampliar el hangar mientras de produce (Fixed by zorro2666).-
- [Fix][Bug #26] No sale el nombre del jugador en color verde en las estadнsticas.-
- [Fix][Bug #27] Bug que permite ampliar el laboratorio e investigar al mismo tiempo.-
- [Fix][Bug #29] Bug en el select de las estadнsticas al cambiar la pбgina mostrando la primer pбgina siempre.-
- [Fix][Bug #30] Problemas con los campos del planeta y las colas de contrucciуn.-
- [Fix][Bug #32] Bug para ver el reporte de combate desde el panel de administraciуn.-
- [Fix][Bug #33] Bugs diversos menores en los misiles interplanetarios (Fixed by lordz).-
- [Fix][Bug #34] Bugs menores que no muestran correctamente los textos.-
- [Fix][Bug #35] Posible bug en los almacenes, incrementan menos de lo que deben.-
- [Fix][Bug #36] No aparece el icono para lanzar misiles en la galaxia.-
- [Fix][Bug #37] Bug que provoca que las colonias en la visiуn general se vean en filas de 5 y no de 2.-
- [Fix][Bug #38] Bug en la misiуn colonizar, si se alcanzу el limite de planetas entonces regresa instantaneamente sin respetar los tiempos.-
- [Fix][Bug #39] Bug en las expediciones que provoca la perdida de la materia oscura.-
- [Fix][Bug #40] Bug que no muestra la materia oscura recolectada en las expediciones.-
- [Fix][Bug #41] Pequeсo bug que provoca un error en el update de puntos (Fixed by angelus_ira).-
- [Fix][Bug #42] Problemas con los textos, se pierden las frases y la cantidad de recursos en algunos reportes.-
- [Fix][Bug #43] Problemas con la proteccion de novatos al enviar sondas desde la galaxia y desde flota.-
- [Fix][Bug #44] Problemas con el js que actualiza los recursos, no teniendo en cuenta la velocidad del servidor.-
- [Fix][Bug #45] Los almacenes funcionan mal, debido a un bug en la relaciуn de incremento por nivel.-
- [Fix][Bug #46] bbCode ni HTML funcionan en los textos de la alianza.-
- [Fix][Bug #48] Se perdiу el texto de advertencia en las expediciones.-
- [Fix][Bug #49] Problemas con la actualizaciуn de puntos de la alianza.-
- [Fix][Bug #50] Problemas con los atajos.-
- [Fix][Bug #51] No aparece el icono de los mensajes para responder.-
- [Fix][Bug #52] Bug en la alianza que probaca un error en la base de datos.-
- [Fix][Bug #53] Problemas de duplicaciуn en la misiуn transportar.-
- [Fix][Bug #54] Bug que no permite generar las estadнsticas (Fixed by angelus_ira).-
- [Fix][Bug #55] Bug que mostraba la luna luego de que fuera destruida.-
- [Fix][Bug #56] Bug que no muestra el porcentaje de creaciуn de las lunas.-
- [Fix][Bug #57] Bug que provoca que no se muestren los mensajes en las expediciones.-
- [Fix][Bug #58] No se muestran los informes de construcciуn en el panel del admin.-
- [Fix][Bug #59] Los reportes de construcciуn no figuran en ninguna categorнa.-
- [Fix][Bug #60] Bug que permitia obtener tecnologнas sin ningъn costo.-

- [Cambio] Optimizaciуn del manejo de flotas (By shoghicp).-
- [Cambio] Optimizaciуn del overview del admin (By jtsamper).-
- [Cambio] Reorganizadas algunas carpetas.-
- [Cambio] Ahora los administradores no podrбn borrarse a si mismos.-
- [Cambio] Ahora sуlo los administradores podrбn borrar jugadores.-
- [Cambio] Reducciуn de lнneas y simplificaciуn en el panel de admnistraciуn.-
- [Cambio] Finalmente el directorio includes queda definido con 3 carpetas (classes, functions y pages).-
- [Cambio] Integrado el auto-update a index.php en la carpeta install.-
- [Cambio] Cuando se registra un usuario ahora es redirigido directamente dentro del juego.-
- [Cambio] Se volvio al viejo sistema de mensajes.-
- [Cambio] El pack de idioma de divide en 4 archivos:

-------- ADMIN.mo -> TODO LO DEL PANEL DE ADMINISTRACIУN.-
-------- CHANGELOG.mo -> CHANGELOG TAL Y CUAL COMO ES CONOCIDO.-
-------- INGAME.mo -> TODO EL CONTENIDO INTERNO DEL JUEGO Y NO ACCESIBLE SIN TENER UNA CUENTA.-
-------- PUBLIC.mo -> TODO EL CONTENIDO PЪBLICO DEL JUEGO (index.php, reg.php, clave perdida y contacto).-

- [Cambio] Ahora en la pбgina de la flota se muestra correctamente la velocidad de las naves al posicionar el mouse sobre el nombre de las mismas.-
- [Cambio] Ahora al realizar cualquier movimiento de flota desde la galaxia, tambiйn se pasa el valor de la misiуn por lo que si por ejemplo seleccionas atacar ya aparecerб marcado en el envнo de las flotas.-
- [Cambio] Ahora si el jugador esta inactivo podrб ser atacado, funcionando de la misma forma que en el ogame original.-
- [Cambio] Los archivos ShowFleetPage.php, floten1.php, floten2.php, y floten3.php ahora utilizan plantillas.-
- [Cambio] Finaliza el soporte a las siguientes versiones v1.4a/v1.4b/1.4c,por lo tanto no habrб mбs auto-update.php.-
- [Cambio] class.FlyingFleetHandler.php maneja todo lo que sea flotas, misiones y funciones especificas de las mismas.-
- [Cambio] Eliminada la experiencia de guerrero y minero.-
- [Cambio] Las funciones CreateFleetPopupedMissionLink, CreateFleetPopupedFleetLink y BuildHostileFleetPlayerLink fueron hubicadas en class.FlyingFleetsTable.php.-
- [Cambio] Dentro de la clase class.FlyingFleetsTable.php, encontramos las funciones BuildFleetEventTable y BuildFlyingFleetTable y todas las funciones que estas necesitan para funcionar.-
- [Cambio] rw.php ahora se llama CombatReport.php.-
- [Cambio] raketenangriff.php del root cambiado a MissilesAjax.php; y flottenajax.php cambiado a FleetAjax.php.-
- [Cambio] La funciуn GetNextJumpWaitTime fue movida de GeneralFunctions.php a class.ShOWInfosPage.php.-
- [Cambio] infos.php y jumpgate.php se encuentran en class.ShOWInfosPage.php.-
- [Cambio] Eliminado quickfleet.php no tenнa utilidad.-
- [Cambio] Home reprogramado y simplificado.-
- [Cambio] Ahora los oficiales espнa y comandante son obtenidos desde la base de datos directamente y no suman espionaje y computaciуn, asi es mбs fбcil de administrar.-
- [Cambio] constantes.php nuevamente se llama constants.php y funciones.php se llama ahora GeneralFunctions.php.-
- [Cambio] class.ShowShipyardPage.php maneja la construcciуn de defensas y naves.-
- [Cambio] Implementado el diseсo del OGame original para el overview.-
- [Cambio] Adaptado el diseсo de la pбgina de los oficiales al resto del juego.-
- [Cambio] En la visiуn de la galaxia no se realizan mas revisiones de los campos de los planetas.-
- [Cambio] La funciуn sendnewpassword fue integrada al lostpassword en el archivo index.php.-
- [Cambio] Limitada la query que traia los datos en la visiуn del imperio, reducida un poco la carga.-
- [Cambio] Las funciones de Strings.php fueron movidas a funciones.php.-
- [Cambio] Ahora si no tenes materia oscura para reclutar oficiales aparecerб el reclutar en rojo y bloqueado.-
- [Cambio] Notar que el manejo de las pбginas esta en game.php.-
- [Cambio] Todas las pбginas del juego ahora se manejan con funciones y/u objetos.-
- [Cambio] Inicio de la exportaciуn del cуdigo a objetos.-
- [Cambio] Eliminados los title de las pбginas, ahora sуlo se muestra el nombre del servidor.-
- [Cambio] Ahora la base lunar sуlo da 3 campos por nivel, tal cual y como es en el ogame original.-
- [Cambio] Ahora para mostrar que un usuario fue baneado, se imprime un texto y no se recurre a una plantilla.-
- [Cambio] Ahora no aparecen mбs mensajes de confirmaciуn al editar, crear o borrar una nota.-
- [Cambio] Ahora las notas nuevamente se abren en un pop-up.-
',

'2.3' => ' 30/05/09

- Corregido un bug que no permitнa cambiar el rango a los miembros dentro de las alianzas.-
- Varios cambios en el panel del admin:

-------- Integrados todos los archivos de lenguaje.-
-------- Renombrado el archivo para el reset del universo.-
-------- Unos cuantos cambios en mats.php, tanto de estilos como limpieza de cуdigo.-
-------- Cambios en el left-menu del panel de administraciуn.-
-------- Renombrados algunos archivos y realizadas algunas correciones menores.-
-------- Unos cuantos ajustes en los textos y plantillas de varios archivos.-
-------- Mensaje de confirmaciуn al intentar eliminar a un jugador del servidor.-
-------- El archivo mats.php ahora se llama adminresources.php, ademas se le integro todos los archivos que manejaban las tecnologнas y recursos.-
-------- Solucionado el bug de la actualizaciуn de puntos.-
-------- Nueva funciуn (optimizar tablas) (By Saint).-
-------- Corregido un bug que al crear una luna no le asignaba el nombre seleccionado.-
-------- Nueva funciуn (eliminar luna) (By tonique).-
-------- Corregido un bug que en la lista de lunas no mostraba el id real de la luna.-
-------- Si el usuario no tiene nivel 1 al menos no podrб ver nada del panel de administraciуn.-
-------- Optimizadas algunas querys en messall.php
-------- Eliminado el QueryExecuter.php

- Se finalizб el soporte a las versiones v1.4d/v1.4e/v1.4f y tambiйn el auto-update de las mismas.-
- Eliminadas algunas querys innecesarias de MissionCaseMIP.php.-
- Se elimino una query innecesario de MissionCaseRecycling.php.-
- Limpieza de la base de datos de campos innecesarios dentro de la tabla users.-
- Algunos cambios y mejoras en el update.php.-
- Ahora sуlo sumarбn puntos de guerrero los jugadores que realicen batallas y no ambos.-
- Reparado un bug que mostraba el mensaje de la flota al finalizar la misiуn.-
- La experiencia del minero ya no se muestra mбs con decimales.-
- Se volviу al antiguo diseсo de la construcciуn de edificios.-
- Corregido un bug que en al finalizar una construcciуn en el overview aparecнa Construcciуn() en vez de Libre.-
- Algunas modificaciones en los crйditos.-
- Modificados algunos aspectos en el aspecto interno del juego.-
- Cambiada la imagen dentro del juego.-
- Rediseсado el index, espero que les guste.-
- Agregado un favicon, cada uno podrб cambiarlo por el que quiera.-
- Eliminados algunos residuos provenientes de otras versiones.-
- Eliminados los frames, ahora el menu se muestra con la funciуn ShowLeftMenu.php y algo de estilos css para ajustar todo.-
- Cambiados todos los $xnova_root_path por $xgp_root.-
',

'2.2' => ' 06/05/09

- Se reemplazo el menъ derecho e izquierdo por el original, y la imagen del fondo tambiйn.-
- Revisado todo messages.php,se eliminaron querys innecesarias, se organizo el cуdigo, se restringieron algunas querys para optimizar la pбgina, se elimiaron elementos sin utilidad y se integro el lenguaje.-
- Toda la galaxia fue revisada, se hicieron algunas correciones en los textos y algunas mejoras visuales.-
- Corregido un bug que impedia cambiar la cantidad de planetas, sistemas y galaxias que se podнan utilizar en el universo (modificable desde constantes.php), recomiendo dejarlo en 9-499-15, asi no saturan mucho el juego.-
- Renombrado functions.php a funciones.php
- Limpieza y revisado de constants.php, renombrado a constantes.php.-
- Corregido un bug en la pбgina de tecnologнas.-
- Eliminadas las vars de los mensajes, no tenнan utilidad.-
- Se revisaron nuevamente todas las funciones y fueron nuevamente reasignadas utilizando el sistema de funciones_A y funciones_B.-
- Solucionado el bug de las pбginas en blanco, dejando la versiуn bastante estable [BETA].-
- Nueva forma de distribuir las funciones, en A y B. Para mas detalles lean la informaciуn que deje comentada en commons.php, esto es provisorio, aunque creo que es la mejor forma de agilizar el juego, y tenerlo mбs estable.-
- Pequeсo cambio en el ingreso, eliminando algunas lineas.-
- Algunos cambios en el commons.php y eliminadas algunas cosas innecesarias.-
- Corregido un pequeсo bug en las listas de lunas.-
- Corregido un bug en la opciуn de crear lunas.-
',

'2.1' => ' 02/05/09

- Pequeсo cambio en el index y la selecciуn de la pбgina.-
- Incluido reg.mo directamente a reg_form.tpl y reg.php.-
- Modificado el diseсo del registro y de la pбgina de clave perdida.-
- Correcciones grбficas en el index.-
- SACS funcionando al 50% [problemas en la coordinaciуn de los tiempos y en la visiуn de los movimientos de flotas].-
- Cambio visual en las estadнsticas, ahora el *, +1 y -1 (rankplus), se muestra con js(overlib).-
- Limpieza en commons.php con lo que durante el movimiento de flotas reducira la carga del juego.-
- Ahora al realizar un espionaje ya no aparecerб la pбgina en blanco ni tampoco tirara error.-
- Corregidos unos cuantos bugs provocados por la distribuciуn de las funciones.-
- Nuevas imбgenes de planetas, mucho mбs vistosas.-
- Corregido un pequeсo bug que no permitнa ver las pбginas publicas(contact.php, reg.php, credit.php y la secciуn de clave perdida).-
',

'2.0' => ' 23/04/09

- Visiуn general del panel del admin mejorada, ajustada mejor la tabla e integrado el lenguaje a las plantillas.-
- Simplificaciуn del sistema de crйditos, e integraciуn del lenguaje.-
- Integrado el idioma a resources.php y a las respectivas plantillas.-
- Cambios en las tablas de las estadнsticas, incluciуn del lenguaje a las plantillas, revisiуn del cуdigo y algunas mejoras en la carga.-
- Algunos cambios visuales en fleet.php.-
- Eliminada la funciуn AdminMessage, cumplia la misma funciуn que message.-
- Optimizaciуn e integraciуn del lenguaje a admin/settings.php
- Algunas correcciones que previenen que por la actualizaciуn de puntos se provoque un bug en el panel de administraciуn.-
- Optimizadas algunas querys de las flotas en commons.php.-
- Correciones en algunos textos en los mensajes de movimientos de flotas.-
- Mejora de seguridad, no podrбs ver las pбginas internas del juego sino te logueaste.-
- Ahora se pueden ver bien los mensajes de error e informes de los mensajes.-
- Corregido un bug que al abandonar un planeta no borraba la luna, y esta podнa ser utilizada.-
- Simplificaciуn y reorganizaciуn de BatimentBuildingPage.php.-
- Correcciones visuales en los edificios, y correciones de algunas tablas para ajustarlas mejor.-
- Nueva imagen de materia oscura en el menъ superior, tambiйn se ampliaron los tamaсos de las imбgenes.-
- Reparado un bug que permitнa mover flotas en modo vacaciones.-
- Traducido el mensaje del modo vacaciones, y corregido un bug que no mostraba el tiempo real de vacaciones.-
- Cambiados algunos $ugamela por $xnova.-
- Implementaciуn de seguridad, fue renombrado el archivo extension.inc a extension.inc.php, no estaba protegido y podнa leerse su contenido.-
- Algunas correcciones y simplificaciуn del cуdigo en buddy.php.-
- Revisado todo el notes.php:

--------- Plantillas agregadas a su carpeta correspondiente "notes".-
--------- Algunas correciones visuales.-
--------- Integraciуn del idioma a las plantillas.-
--------- Reparados algunos bugs.-
--------- Ahora al editar el mensaje, se muestra el asunto y el mensaje.-
--------- Conteo de caracteres en js aplicado.-

- Eliminadas algunas funciones de administraciуn.-
- Reparado un bug que no mostraba el lнmite real de las flotas posibles a enviar.-
- Oficiales:

--------- Algunas correciones visuales.-
--------- Oficiales pendientes por reparar: Almirante y General.-
--------- Oficiales funcionando: Geуlogo, Ingeniero, Tecnуcrata, Constructor, Cientнfico, Almacenista, Defensor, Bunker, Espнa, Comandante, Destructor, Raider y Emperador.-
--------- Reparados los oficiales espнa y Comandante.-
--------- Reparado el oficial empeador(By thyphoon) y destructor(By angelus_ira).-
--------- Integraciуn del idioma a las plantillas y cуdigo.-

- Limpieza de scripts.-
- Re-organizadas todas las funciones del juego (optimizandolo increнblemente)(cada funciуn se asigno a su archivo correspondiente).-
- Eliminado CombatEngine.php.-
- Algunas correciones en commons.php para agilizar el juego en general.-
- Limpieza y optimizaciуn del instalador.-
- La funciуn doquery fue unificada tambiйn dentro de functions.php.-
- Las funciones de unlocalised.php fueron integradas a functions.php
- Limpieza de funciones inutiles en includes/functions:

--------- Eliminado RevisionTime.php.-
--------- Eliminado SecureArrayFunction.php.-
--------- Eliminado ResetThisFuckingCheater.php.-
--------- Eliminado ElementBuildListQueue.php, el archivo ElementBuildListBox.php cumple la misma funciуn y se encuentra en uso.-

- Limpieza en functions.php,se borraron algunas funciones sin utilidad alguna.-
- Limpieza en unlocalised.php,se borraron algunas funciones sin utilidad alguna o vacнas.-
- Se reorganizaron casi todas las plantillas y se borraron algunas mбs sin utilidad (algunas pedientes a organizar).-
- Se borraron todas las plantillas de la galaxia que no tenнan utilidad(la galaxia la genera el cуdigo php dinбmicamente).-
- Revisado todo el search.php:

--------- Borradas algunas lineas.-
--------- Reorganizado el cуdigo.-
--------- Reorganizadas las plantillas en una carpeta en templates.-
--------- Se integro search.mo a las plantillas.-
--------- Se corrigiу un bug que no mostraba la alianza en la bъsqueda por usuarios.-
--------- Se corrigiу un bug que no redirigнa correctamente a la vista de la alianza.-
--------- Se corrigiу un bug dentro de la alianza para poder verla desde search.php

- Revisado todo el mercader:

--------- Adherido marchand.mo a sus respectivas plantillas.-
--------- Corregidas todas las plantillas y bugs en la muestra de los recursos(no aparecen mбs en eltop).-
--------- Simplificaciуn del cуdigo php, reorganizado y reprogramado lo que no funcionaba bien.-
--------- Corregidas las validaciones, admiten ceros, pero no nъmeros negativos.-
--------- Aсadidas las plantillas respectivas a una carpeta en templates(para una mejor organizaciуn).-

- Cookies.mo integrado a su archivo correspondiente.-
- Algunos textos fueron colocados en system.mo, ya que hacen al caracter general del juego, y no de un sector en especifico.-
- Optimizado MissionCaseAttack.php.-
- Optimizado el overview, se elimino cуdigo innecesario, se reorganizу, se eliminaron querys que no tenнan utilidad y se integro el idioma a las plantillas.-
- Reubicados algunos archivos.-
- Limpieza de la base de datos, de cosas que no se utilizaban.-
- Reorganizado el menъ de opciones, integraciуn del idioma a la plantilla y se eliminaron querys innecesarias.-
- Algunos archivos de texto fueron integrados directamente a los archivos para agilizar el juego y su velocidad.-
- Se reorganizaron algunas plantillas y se eliminaron algunas otras inъtiles.-
- Eliminados los emoticones.-
- Como siempre actualizados el auto-update y el instalador para que todo sea mбs facil.-
- Cambios en el instalador.-
- Optimizadas unas cuantas pбginas.-
- login.php, lostpassword.php y logout.php unificados en el index.php mejorando un poco el rendimiento y organizaciуn.-
- Algunas correcciones visuales en la visiуn del imperio.-

- Revisada toda la alianza:

--------- Mejoras varias.-
--------- Mejoras en lenguajes.-
--------- Mejoras en plantillas.-
--------- Se agregaron validaciones.-
--------- Se reorganizу el cуdigo.-
--------- Se reparo el texto de las solicitudes, ahora podrбs editarla.-
--------- Todos los mensajes ahora te redirigiran.-
--------- Se corrigiу un bug en los rangos.-
--------- Se optimizу un poco, se eliminaron lineas inъtiles y se fixearon algunos bugs.-
--------- Se repararon todos los errores encontrados en los textos y plantillas que no se mostraban, asi como cosas que no se realizaban.-

- Cuando un usuario falla al intentar el login ahora es redirigido al inicio.-
- Mejorado el index ahora funciona mucho mбs rбpido.-
- Mejorados algunos textos en general, y corregidos algunos detalles.-
- Rediseсado el sistema de ingreso al panel del admin y regreso al juego.-
- Limpieza de archivos y residuos.-
- Eliminado el chat, loteria, razas, simulador, tutoria, records y todo aquello que no consideraba necesario.-
- Reprogramados los menъs derechos e izquierdos.-

- Un resumen de las figuras mбs destacadas de este proyecto:

--------- Tomo las riendas sobre la 1.5b saltando a la 2.0 para trerles todas las mejoras enunciadas a continuaciуn [By lucky].-
--------- Partiendo de la version 0.9a llegando hasta la 1.5b del XG Proyect por lucky, PowerMaster, Calzon, Tarta, Tonique y muchas personas mбs.-
--------- Continuado por UGamela Britania con varias mejoras, seguido por el equipo francйs Raito, Chlorel, e-Zobar y Flousedid.-
--------- Proyecto ogame para todos y con todas las funciones iniciado por Perberos.-
',

'1.5b' => ' 03/04/09

- Cambios y correcciones en templates y textos.-
- Loteria reparada (By lucky).-
- Correciones en el instalador, soportando correctamente las razas, y tambiйn en el auto-update.-
- Razas corregidas (By Tonique).-
- Corregido un bug en el instalador.-
',

'1.5a' => ' 26/03/09

- Corregido el link de administraciуn.-
- Mejoras en el instalador.-
- Fix corregido bug que mostraba mal la leyenda en la galaxia.-
- Actualizado el auto-update para poder pasar fбcilmente de la versiуn 1.4f o de la 1.4c a la 1.5a.-
- Ahora la instalacion incluye la loterнa y el chat, no deberбs hacer nada manualmente.-
- Arreglada la pбgina de amigos ahora deberнa mostrar bien a tus amigos y no a vos (By lucky).-
- Mejorado el auto-update de puntos, ahora podrбs instalar sin realizar modificaciones en los archivos.-
- Unificamos la versiуn de XG Proyect con la de calzon.-
',

'1.4f' => ' 18/03/09

- Fix pequeсas correciones en la base de datos.-
- Fix pequeсas correcciones en traducciones generales.-
- Fix Corregidas variables en alianza, nueva estructuracion, mejor optimizada.-
- Mod Agregado terraformer y super terraformer a constants.php, (personalizable campos que dara cada uno).-
- Mod Administradores u operadores no aparecen mas Estadisticas.-
- Mod Completadas algunas imagenes faltantes en el skin, cambiada la de la supernova por una de mejor calidad.-
- Mod Optimizacion de consultas y variables generales (sistema mas limpio).-
- Mod Nuevo edificio, Super Terraformer, aumenta 10 campos por nivel (winjet).-
<font color="red">- Tecnologias y naves unicas de razas. 70% completado.-</font>
<font color="red">- Formas de Gobierno (democracia, socialismo y pirateria) 30% completado.-</font>
<font color="red">- Fix a bug destruccion de luna.-</font>
',

'1.4e' => ' 12/03/09

- Fix a textos e imagenes de naves y defensas nuevas asi como a razas.-
- Fix Enviar mutiples flotas, expediciones, misiones, al ir atras (modo test por ahora).-
- Fix Corregido bug en consumo de deuterio (flotenajax.php).-
- Fix corregido bug al abandonar colonias por fallo seguridad (overview.php).-
- Fix En Estadisticas aparecias en una alianza aunque ya hubieras salido (alliance.php).-
- Mod 4 Nuevas naves: Interceptor, Cazador Crucero, Transportador y Titan.-
- Mod 2 Nuevas defensas: Caсon de Fotones y Base Espacial.-
- Mod Nueva Tecnologia de Desarrollo, aumenta colas posibles a edificios.
<font color="green">- Mod Razas: Humanos, Aliens, Predators y Darks, con cada nivel aumenta:.-</font>
<font color="green">- Humanos: Mina Metal +3% produccion, +2% Ataque y Escudos.-</font>
<font color="green">- Aliens: Mina Cristal +3% produccion, +3% Blindaje.-</font>
<font color="green">- Predators: +10% Ataque.-</font>
<font color="green">- Darks: Sintetizador Deuterio +3% produccion, +4% Blindaje y Escudos.-</font>
',

'1.4d' => ' 09/03/09

- Fix algunas traducciones.-
- Fix Ajustado a resolucion 1024x768, reacomodo en columnas de edificios y frames.php-
- Fix multiplicacion/Duplicacion de ligeros y estrellas de la muerte (flotten1.php).-
- Fix Seguridad de carpetas, una mas, aparte de la que ya existia.-
- Fix en Mercader, devolvia recursos al meter numeros negativos (marchand.php).-
- Fix Misiles (projectxnova) adaptado y corregido a esta version (MissionCaseMIP.php).-
- Fix agregado entero en funcion investigaciones (ResearchBuildingPage.php).-
- Fix, pequeсa correccion en alianzas rangos y administracion(alliance.php).-
- Fix, Correccion en Galaxia (galaxy.php).-
- Mod/Fix Arreglo a mensajes(project xnova) adaptado, corregido y aumentado para esta version.-
- Mod actualizacion automatica (ahora si es automatica) y no consume recursos.-
- Mod Edificios en columnas de 5.-
- Mod Menu Derecho agregada compatibilidad, reordenadas las funciones.-
- Mod Agregado Records (Records.php).-
- Mod Agregado Chat.-
- Mod Agregado Simulador de Batallas.-
- Mod Agregado Loteria (project xnova), adaptado y corregido a esta version.-
- Mod Reacomodo vision general (projectxnova), corregida compatilidad (overview.php).-
- Mod Recursos en tiempo real (tonique) modo test por ahora.-
- Borrado actualizacion automatica, consume muchos recursos (todos haciendo click a vision general).-
',

'1.4c' => ' 08/02/09

- Eliminados los recursos en tiempo real debido a que se quedaban congelados.-
- Reparados los oficiales espнa y comandante.- (By jtsamper foro project.xnova.es)
- En la galaxia ya no puedes reciclar o espiar sin deuterio.-
- Prevenir nъmeros negativos y carбcteres no numйricos en la galaxia (By neurus foro Xproject.xnova.es).-
- Ahora para ver la galaxia necesitas deuterio (Original project.xnova.es fixeado por lucky).-
- Al disolver una alianza esta ya no aparece en las estadнsticas (By xesar foro project.xnova.es).-
- Corregida una redirecciуn que funcionaba mal en la alianza.-
- Corregido un pequeсo error de sintaxis en la flota que tiraba severos reportes de errores (Gracias edering).-
- Agregado un mensaje recordatorio de como se debe incrementar o eliminar la materia oscura (Gracias edering).-
- Anuncios eliminados (Por votaciуn de los usuarios de XG).-
- El auto-update no soporta mбs las siguientes versiones:  v0.9a/v1.0a/v1.0b/v1.1a/v1.1b/v1.1c/v1.2a/v1.2b/v1.2c/v1.3a (Si tienes alguna des estas versiones deberбs usar un update anterior).-
- Ahora en la busqueda al hacer click en el link te redirecciona al sistema del jugador y no al tuyo (By Anghelito).-
',

'1.4b' => ' 06/12/08

- Desbaneo reparado.-
- Oficiales reparados.-
- Ahora al iniciar sesiуn con tu cuenta, iniciarб siempre desde el planeta principal y no desde una colonia.-
- Un moderador u operador ya no podrб cambiarse los permisos a Administrador.-
- Galaxia optimizada.-
- Ahora cuando colonizas tu planeta se llamarб "Colonia" y no "Planeta Principal" (By lucky).-
- El auto-update no soporta mбs las siguientes versiones:  v1.0a/v1.0b/v1.1a/v1.1b/v1.1c/v1.2a/v1.2b/v1.2c/v1.3a (Si tienes alguna des estas versiones deberбs usar un update anterior).-
- Corregidas algunas redirecciones y mejoradas otras.-
- Ahora puedes usar espacios en blanco en el nombre de tu planeta (By lucky).-
- Borrado de archivos innecesarios (esto no termina mбs).-
- Reparada la tabla que muestra las flotas en vuelo en el panel del admin.-
- Mejoras, organizaciуn, limpieza y optimizaciуn del lenguaje (No pongo mбs que cambie en los lenguajes porque ya es detallar mucho, para nada).-
',

'1.4a' => ' 06/12/08

- Reparado el reset del universo.-
- El auto-update no soporta mбs las siguientes versiones: v1.0a/v1.0b/v1.1a/v1.1b/v1.1c/v1.2a (Si tienes alguna des estas versiones deberбs usar un update anterior).-
- Mбs limpieza de archivos innecesarios.-
- Limpieza y pulido del panel de admin (lenguaje).-
- Lista de planetas <-> Lista de usuarios cambiado (lenguaje - Gracias Alberto14).-
- Ahora puedes agregar y remover materia oscura desde el panel de administraciуn (By lucky).-
- Actualizaciуn en tiempo real de los recursos (By Alberto14).-
- Cambidas las imбgenes del XNova, por las imбgenes del OGame original.-
- Borradas imбgenes innecesarias.-
- Optimizadas las imбgenes de los oficiales.-
- Eliminado el multi totalmente (A pedido del pъblico).-
- Eliminados los records totalmente (A pedido del pъblico).-
- Eliminado el chat totalmente (A pedido del pъblico).-
- Traducidos algunos textos en el formulario de envнo de mensajes (lenguaje).-
- Complementado el infos.mo con los datos del verdadero OGame (lenguaje).-
- Pulido y limpieza del search (lenguaje).-
- Pulido y limpieza del overview (lenguaje).-
- Pulido y limpieza del leftmenu (lenguaje).-
- Pulido y limpieza del registro (lenguaje).-
- Pulido y limpieza del login (lenguaje).-
- Cambios de lenguaje en notes.-
- Cambios en el login Contact -> Contacto y Forum -> Foros.-
- Eliminado player.mo - no tenнa ninguna utilidad.-
- Limpieza del archivo de lenguaje login.-
- Reemplazados todos los "Titanio", "Silicio" y "Gashofa" por "Metal", "Cristal" y "Deuterio".-
- Correciones de lenguaje en el install y limpieza de dicho archivo (Gracias Alberto14).-
',

'1.3c DMV' => ' 30/11/08 "DMV = Dark Matter Version Exclusivo Xtreme-gameZ.com.ar"

- Correciones en los lenguajes de la supernova o super nave de batalla y el protector planetario (algo siempre me olvido).-
- Modificaciуn de la ubicaciуn de algunos arhcivos.-
- Eliminada una carpeta llamada .svn a la cual no le encontre utilidad.-
- Limpieza de archivos innecesarios y duplicados.-
- Implementada la materia oscura (Cуdigo 100% x lucky) (Gracias Reyndio por la idea).-
----- Los oficiales ahora se manejan por la materia oscura 1 punto oficial = 1000 materia oscura.-
----- En las expediciones se obtiene la materia oscura necesaria.-
----- No existen mбs los puntos de oficiales, aun asi se sube el nivel de minero y flota.-
----- Se siguen mostrando los registros de ataque.-
----- Auto-Update actualizado especialmente para soportar la materia oscura.-

- Ya no se pueden atacar lunas + fuerte o + debiles que uno (By Neurus).-
- Panel del admin, "Utilisateur?" -> "їUsuario?", modificaciуn en el lenguaje.-
- Por razones de seguridad elimine el phpinfo.-
- Panel del admin, "Lista de Usuarios" -> "Lista de Planetas", modificaciуn en el lenguaje (Gracias Alberto14).-
- Solucionado el error en el orden por id de la alianza (By tarta).-
',


'1.3b EU' => ' 30/11/08

- No hace falta mбs ingresar el nombre del planeta, por defecto es "Planeta Principal".-
- Eliminadas imagenes del "sexo".-
- Optimizada la imagen del inicio, ahora carga mбs rбpido.-
- Compatibilidad del auto-update con todas las versiones.-
- Nueva versiуn del auto update, mбs comprensible(creo).-
- Reparado el problema con la instalaciуn (Gracias Anghelito).-
',

'1.3a' => ' 29/11/08

- XNova 100% TRADUCIDO AL ESPAСOL [PUDE HABERME SALTEADO ALGO POR FAVOR AVISAR](By lucky).-
- Limpieza de scripts, eliminamos varios archivos de la carpeta scrips que notamos no necesarios.-
- Reparada la validaciуn del index, ahora si la carpeta install existe no podras acceder al juego (By lucky).-
- Arreglado el modo vacaciones, ya no puedes entrar en vacaciones cuando estas atacando (By lucky).-
- No se muestran mбs los recursos negativos.-
- Redirecciуn luego de enviar una flota (By tarta).-
- Ahora los dнas se muestran con una "d" y no con una "j" (By tarta).-
- Nuevamente agregamos los emoticons.-
- Ahora puedes cambiar el nombre en el juego, por fin solucionamos esto.-
- Nuevo diseсo del auto-update, mucho mas vistoso y atractivo.-
- Reparada la instalaciуn, ahora funcionan los misiles al instalar el juego.-
',

'1.2c EU' => ' 26/11/08

- Reparada la instalaciуn.-
',

'1.2b' => ' 26/11/08

- Misiles finalmente funcionando (By lucky).-
- Desbaneo automбtico (By Anghelito).-
- Reparado el modo vacaciones.-
- Traducciones en varios archivos (By edering).-
- Reparado el modo debug (By tarta).-
- Reparado el link de las notas (By lucky).-
- Eliminada la carpeta emoticones.-
- Fix ranking de flotas en vuelo (By Pada).-
- Mejoras en archivos de lenguaje.-
- Cambios en el mensaje de bienvenida.-
- Records reparados.- (By tarta).-
- Actualizado el auto-update para poder actualizar: 0.9a -> 1.2a / 1.1b -> 1.2a / 1.2a -> 1.2b (By lucky).-
- Cambios en el instalador.-
- Se elimino una tabla que no hacia falta.-
',

'1.2a' => ' 19/11/08

- Actualizado el auto-update para poder actualizar: 0.9a -> 1.2a y 1.1b -> 1.2a .-
- Reorganizaciуn, recodificaciуn y reestructuraciуn de los misiles interplanetarios, ademas de solucionar seberos bugs.-
- Solo se permiten caracteres alfanumericos en el nombre de los planetas, evita serios bugs y filtros de seguridad.-
- Arreglado el orden por puntos en la alianza.-
- Tutorial funcionando.-
- Correcciones en el mensaje de bienvenida pos-registro.-
- Solucionado el bug que no permitнa la transferencia de la alianza.-
- Solucionado el bug que hace que salga el rango equivocado al usuario en la lista de miembros de la ally.-
- Solucionado el bug que permitнa que se envien solicitudes una vez que la alianza habia sido borrada.-
- Reparada la red de investigaciуn intergalбctica.-
- Cupula y protector planetario funcionando, y cada una solo puede ser edificada una vez.-
',

'1.1c' => ' 19/11/08

- Cambios en la organizaciуn de la carpeta templates.-
- Algunos fixes en el leftmenu del admin.-
- Nuevamente reparada la seccion de de Annonces (sirve para comerciar).-
- Volvimos a implementar el leftmenu antigьo, funciona mбs rбpido.-
- Mejoras en algunas traducciones, y aсadidas otras.-
- Aсadida la hora al chat. [Aъn no funciona en hostings].-
- Limpieza de archivos inecesarios y/o sin ninguna utilidad.-
- Aсadido el auto-update.-
- Eliminado el upgrade desde ugamela.-
- Mejoras en la instalaciуn.-
',

'1.1b' => ' 30/10/08

- Aсadido un tutorial, desarrollado por PowerMaster para el XNova de Xtreme-gameZ.com.ar.-
- Cambios de nombre del archivo de instalacion "Installeur" a "Instalacion de XNova".-
- Cambios en el leftmenu para usuarios.-
- Actualizacion de Puntos Automaticamente, ahora si anda.-
- Introduccion del Release de Xtreme-GameZ en "credit.php" e "install.php".-
- Cambios de idioma de carpeta "fr" a carpeta "es" (requiere instalacion).-
',

'1.1a' => ' 28/10/08

- Antes, si mandaban una flota y cambian de planeta, tiraba error.-
- Antes, cuando estaban leyendo mensajes y cambian de planeta, tiraba error.-
- Ahora al cancelar una investigaciуn te devuelve los recursos.-
- Cambio en el texto del primer mensaje recibido al registrarse en el juego.-
- Agregadas las estadнsticas de batalla.-
- Fueron agregadas las defensas al ranking de la Visiуn General.-
',


'1.0b' => ' 26/10/08

- Primer release disponible para los usuarios.-
- Eliminado el warning que aparecнa en la instalaciуn del sistema.-
- El instalador ahora incluye la actualizaciуn de puntos automбtica, por ende el usuario ya no debera tocar nada en el cуdigo.-
- Aplicada la actualizaciуn automбtica de puntos.-
',


'1.0a' => ' 24/10/08 "Versiуn Inicial"

- Cambios de lenguaje en el changelog (100% traducido).-
- Mejora del menъ de la izquierda se "visualiza" algo mejor.-
- Correciones de lenguaje en el install (install.mo).-
- Correciones en el Marchand (Mercader), ya esta funcionando correctamente, no tira mбs ese error del lenguaje.-
- Fixes en el link de Annonces, ahora esta funcionando, ya puedes publicar lo que desees comercias.-
- Inicio del proyecto XG (XG Proyect) basandonos en el pack hecho por XNova versiуn 0.9a.-
',
);
?>