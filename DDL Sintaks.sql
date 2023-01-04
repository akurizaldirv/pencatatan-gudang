CREATE TABLE PROVINSI (
    ID_PROVINSI   CHAR (3)     NOT NULL,
    NAMA_PROVINSI VARCHAR (30) NOT NULL,
    PRIMARY KEY (
        ID_PROVINSI
    )
);

CREATE TABLE [KOTA/KAB] (
    ID_KOTA     CHAR (3)     NOT NULL,
    ID_PROVINSI CHAR (3)     NOT NULL,
    NAMA_KOTA   VARCHAR (30) NOT NULL,
    PRIMARY KEY (
        ID_KOTA
    ),
    FOREIGN KEY (
        ID_PROVINSI
    )
    REFERENCES PROVINSI (ID_PROVINSI) ON DELETE RESTRICT
                                      ON UPDATE RESTRICT
);

CREATE TABLE PENGIRIM (
    ID_PENGIRIM    CHAR (7)      NOT NULL,
    ID_KOTA        CHAR (6)      NOT NULL,
    NAMA_PENGIRIM  VARCHAR (30)  NOT NULL,
    EMAIL_PENGIRIM VARCHAR (30)  NOT NULL,
    NOTELP_CP      VARCHAR (16)  NOT NULL,
    NAMA_CP        VARCHAR (30)  NOT NULL,
    ALAMAT         VARCHAR (255),
    PRIMARY KEY (
        ID_PENGIRIM
    ),
    FOREIGN KEY (
        ID_KOTA
    )
    REFERENCES [KOTA/KAB] (ID_KOTA) ON DELETE RESTRICT
                                    ON UPDATE RESTRICT
);

CREATE TABLE MERK (
    ID_MERK     CHAR (6)      NOT NULL,
    ID_KOTA     CHAR (6)      NOT NULL,
    NAMA_MERK   VARCHAR (30)  NOT NULL,
    NOTELP_MERK VARCHAR (16)  NOT NULL,
    EMAIL_MERK  VARCHAR (30)  NOT NULL,
    ALAMAT      VARCHAR (255),
    PRIMARY KEY (
        ID_MERK
    ),
    FOREIGN KEY (
        ID_KOTA
    )
    REFERENCES [KOTA/KAB] (ID_KOTA) ON DELETE RESTRICT
                                    ON UPDATE RESTRICT
);

CREATE TABLE PENGIRIM_MERK (
    ID_MERK     CHAR (6) NOT NULL,
    ID_PENGIRIM CHAR (7) NOT NULL,
    PRIMARY KEY (
        ID_MERK,
        ID_PENGIRIM
    ),
    FOREIGN KEY (
        ID_MERK
    )
    REFERENCES MERK (ID_MERK) ON DELETE RESTRICT
                              ON UPDATE CASCADE,
    FOREIGN KEY (
        ID_PENGIRIM
    )
    REFERENCES PENGIRIM (ID_PENGIRIM) ON DELETE RESTRICT
                                      ON UPDATE CASCADE
);

CREATE TABLE LEVEL (
    ID_LEVEL   CHAR (6)     NOT NULL,
    NAMA_LEVEL VARCHAR (15) NOT NULL,
    PRIMARY KEY (
        ID_LEVEL
    )
);

CREATE TABLE ADMIN (
    USERNAME     VARCHAR (16)  NOT NULL,
    ID_LEVEL     CHAR (6)      NOT NULL,
    PASSWORD     VARCHAR (255),
    NAMA_ADMIN   VARCHAR (30)  NOT NULL,
    NOTELP_ADMIN VARCHAR (16)  NOT NULL,
    EMAIL_ADMIN  VARCHAR (30)  NOT NULL,
    PRIMARY KEY (
        USERNAME
    ),
    FOREIGN KEY (
        ID_LEVEL
    )
    REFERENCES LEVEL (ID_LEVEL) ON DELETE RESTRICT
                                ON UPDATE RESTRICT
);

CREATE TABLE FAKTUR (
    ID_FAKTUR   CHAR (10)    NOT NULL,
    USERNAME    VARCHAR (16) NOT NULL,
    ID_PENGIRIM CHAR (7)     NOT NULL,
    WAKTU       DATETIME     NOT NULL,
    PRIMARY KEY (
        ID_FAKTUR
    ),
    FOREIGN KEY (
        USERNAME
    )
    REFERENCES ADMIN (USERNAME) ON DELETE RESTRICT
                                ON UPDATE RESTRICT,
    FOREIGN KEY (
        ID_PENGIRIM
    )
    REFERENCES PENGIRIM (ID_PENGIRIM) ON DELETE RESTRICT
                                      ON UPDATE CASCADE
);

CREATE TABLE KATEGORI (
    ID_KATEGORI   CHAR (6)     NOT NULL,
    NAMA_KATEGORI VARCHAR (15) NOT NULL,
    PRIMARY KEY (
        ID_KATEGORI
    )
);

CREATE TABLE WARNA (
    ID_WARNA   CHAR (4)     NOT NULL,
    NAMA_WARNA VARCHAR (15) NOT NULL,
    PRIMARY KEY (
        ID_WARNA
    )
);

CREATE TABLE BARANG (
    ID_BARANG   CHAR (6)     NOT NULL,
    ID_KATEGORI CHAR (6)     NOT NULL,
    ID_MERK     CHAR (6)     NOT NULL,
    NAMA_BARANG VARCHAR (30) NOT NULL,
    PRIMARY KEY (
        ID_BARANG
    ),
    FOREIGN KEY (
        ID_KATEGORI
    )
    REFERENCES KATEGORI (ID_KATEGORI) ON DELETE RESTRICT
                                      ON UPDATE RESTRICT,
    FOREIGN KEY (
        ID_MERK
    )
    REFERENCES MERK (ID_MERK) ON DELETE RESTRICT
                              ON UPDATE RESTRICT
);

CREATE TABLE WARNA_BARANG (
    ID_BARANG CHAR (6) NOT NULL,
    ID_WARNA  CHAR (4) NOT NULL,
    PRIMARY KEY (
        ID_BARANG,
        ID_WARNA
    ),
    FOREIGN KEY (
        ID_BARANG
    )
    REFERENCES BARANG (ID_BARANG) ON DELETE RESTRICT
                                  ON UPDATE CASCADE,
    FOREIGN KEY (
        ID_WARNA
    )
    REFERENCES WARNA (ID_WARNA) ON DELETE RESTRICT
                                ON UPDATE CASCADE
);

CREATE TABLE PENCATATAN (
    ID_FAKTUR CHAR (10) NOT NULL,
    ID_BARANG CHAR (6)  NOT NULL,
    ID_WARNA  CHAR (4)  NOT NULL,
    UKURAN    INTEGER   NOT NULL,
    JUMLAH    INTEGER   NOT NULL,
    PRIMARY KEY (
        ID_FAKTUR,
        ID_WARNA,
        ID_BARANG,
        UKURAN
    ),
    FOREIGN KEY (
        ID_FAKTUR
    )
    REFERENCES FAKTUR (ID_FAKTUR) ON DELETE RESTRICT
                                  ON UPDATE RESTRICT,
    FOREIGN KEY (
        ID_BARANG
    )
    REFERENCES BARANG (ID_BARANG) ON DELETE RESTRICT
                                  ON UPDATE RESTRICT,
    FOREIGN KEY (
        ID_WARNA
    )
    REFERENCES WARNA (ID_WARNA) ON DELETE RESTRICT
                                ON UPDATE RESTRICT
);




