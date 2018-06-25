@echo off

for /f "tokens=2 delims==" %%a in ('wmic OS Get localdatetime /value') do set "dt=%%a"
set "YY=%dt:~2,2%" & set "YYYY=%dt:~0,4%" & set "MM=%dt:~4,2%" & set "DD=%dt:~6,2%"
set "HH=%dt:~8,2%" & set "Min=%dt:~10,2%" & set "Sec=%dt:~12,2%"

set "datestamp=%YYYY%%MM%%DD%" 
rem& set "timestamp=%HH%%Min%%Sec%"
rem set "fullstamp=%YYYY%-%MM%-%DD%_%HH%-%Min%-%Sec%"
rem echo datestamp: "%datestamp%"
rem echo timestamp: "%timestamp%"
rem echo fullstamp: "%fullstamp%"

set accb_filename=sabre_kx_accb?%datestamp%_*.txt
echo FILE TO BE FOUND IS %accb_filename%
set file_exist=false
set time=300

for /f %%G IN ('dir /b C:\SabreACCB\sabre_kx_accb_????????_*.txt') DO (
set "h=%%G | findstr /C:"sabre_kx_accb?%datestamp%""
)

rem for /F %%a in ('dir /b C:\SabreACCB\sabre_kx_accb_????????_*.txt') do set FileName=%%~na
rem echo filename is %FileName%

:EXECUTOR
if exist C:\SabreACCB\%accb_filename% (
	rem file found
	echo FILE WAS FOUND
	echo ABOUT TO IMPORT FILE
	@start iexplore.exe http://10.1.0.41/Import/LocalImport?fn=%h%
	rem @start iexplore.exe http://www.google.com
	rem allow time for the records to be imported
	echo FILE IS BEING IMPORTED
	rem allow 20mins to execute file
	timeout /t 2700 
	rem clean up! close ie
	echo CLOSING BROWSER
	taskkill /IM iexplore.exe /F
	echo EXECUTED IMPORT PROCESS
	exit
) else (
	GOTO OTHER
)

rem echo error level is %ERRORLEVEL%
rem echo %h%

:OTHER
cls
echo FILE WAS NOT FOUND
echo WILL CHECK FILE IN...
timeout /t %time% /nobreak
GOTO EXECUTOR 