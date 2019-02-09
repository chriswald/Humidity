echo -n `date +"%D %T"` >> values.tsv
echo -n -e "\t" >> values.tsv
./indoorhumidity.sh >> values.tsv
echo -n -e "\t" >> values.tsv
./outdoorhumidity.sh >> values.tsv
echo >> values.tsv
php plot.php > /volume1/web/index.html
