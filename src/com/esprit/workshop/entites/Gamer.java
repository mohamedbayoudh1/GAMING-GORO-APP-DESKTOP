package com.esprit.workshop.entites;


import java.util.Date;

public class Gamer extends User{

    private String tag;
    private int id;

    public Gamer(String nom, String prenom, String email, String password, Date date_naissance, float point, String phone, String about, String photo_profile, String photo_couverture, String tag) {
        super(nom, prenom, email, password, date_naissance, point, phone, about, photo_profile, photo_couverture);
        this.tag = tag;
    }

    public Gamer() {
        super();
    }


    public String getTag() {
        return tag;
    }

    public void setTag(String tag) {
        this.tag = tag;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    @Override
    public String toString() {
        return super.toString() +
                ", tag='" + tag + '\'' +
                ", id=" + id ;
    }
}
