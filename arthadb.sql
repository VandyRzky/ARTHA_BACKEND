create table produk(
id_produk int(3) not null AUTO_INCREMENT,
nama_produk varchar(255) not null,
foto_produk varchar(255) not null,
primary key(id_produk)
)AUTO_INCREMENT = 1;

create table detail_produk(
id_detail_produk int(3) not null AUTO_INCREMENT,
id_produk int(3)not null,
jumlah varchar(255) not null,
harga decimal(10,2) not null,
primary key(id_detail_produk),
constraint fk_id_produk foreign key (id_produk) references produk(id_produk)
)AUTO_INCREMENT = 1;