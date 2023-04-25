package com.esprit.workshop.gui;

import com.esprit.workshop.entites.Gamer;
import com.esprit.workshop.entites.Team;
import com.esprit.workshop.services.ServiceTeam;
import com.itextpdf.text.Document;
import com.itextpdf.text.pdf.PdfContentByte;
import com.itextpdf.text.pdf.PdfTemplate;
import com.itextpdf.text.pdf.PdfWriter;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Node;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.control.TextField;
import javafx.scene.control.*;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.input.MouseEvent;
import javafx.stage.FileChooser;
import javafx.stage.Stage;
import javafx.util.Callback;
import org.knowm.xchart.*;
import org.knowm.xchart.style.Styler.LegendPosition;

import javax.swing.*;
import java.awt.*;
import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.net.URL;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.nio.file.StandardCopyOption;
import java.sql.SQLException;
import java.util.List;
import java.util.ResourceBundle;
import java.util.UUID;

public class Addteam implements Initializable {

    public Button displayStatisticsButton;
    public TableColumn deleteCol;
    private File selectedImageFile;
    private String imageName;
    @FXML
    private ImageView uploadt;
    @FXML
    private TableColumn<Team, String> tabout;
    @FXML
    private ImageView imageteam;
    @FXML
    private TextField tfabout;

    @FXML
    private TextField tflogo;

    @FXML
    private TextField tfnbjoueur;

    @FXML
    private TextField tfnomteam;

    @FXML
    private TableColumn<Team, Integer> tnbjoueur;
    @FXML
    private Button retour;
    @FXML
    private TableColumn<Team, String> tnomteam;
    @FXML
    private TableView<Team> tableteam;
    public ObservableList<Team> data = FXCollections.observableArrayList();
   public Gamer g=new Gamer();

    @Override
    public void initialize(URL url, ResourceBundle resourceBundle) {
        System.setProperty("jdk.gtk.version", "2");
        g.setId(3);
        showteam();
        tableteam.setOnMouseClicked(event -> {
            if (event.getClickCount() == 1) { // vérifie que l'utilisateur a cliqué une fois
                Team teamSelectionne = tableteam.getSelectionModel().getSelectedItem(); // récupère l'objet Groupe sélectionné dans le TableView
                if (teamSelectionne != null) {

                    tfnomteam.setText(teamSelectionne.getNom_team()); // affiche le nom du groupe dans un TextField
                    //System.out.println(groupeSelectionne.getImage());

                    tfnbjoueur.setText(String.valueOf(teamSelectionne.getNb_joueurs()));
                    tfabout.setText(teamSelectionne.getAbout());
                    tflogo.setText(teamSelectionne.getLogo());

                    try {
                        Image img = new Image("C:/Users/bayou/Desktop/WorkshopJDBC3A37/src/com/esprit/workshop/uploadtournoi/" + teamSelectionne.getLogo());
                        System.out.println(teamSelectionne.getLogo());
                        imageteam.setImage(img);
                    } catch (Exception e) {
                        System.out.println("Error loading image: " + e.getMessage());
                    }


                }
            }
        });
    }
    @FXML
    void addteam(ActionEvent event) {
        if (tfnbjoueur.getText().isEmpty() || tfnomteam.getText().isEmpty() || tflogo.getText().isEmpty() || tfabout.getText().isEmpty()) {
            Alert al = new Alert(Alert.AlertType.WARNING);
            al.setTitle("Erreur de donnee");
            al.setContentText("Veuillez verifier les données !");
            al.show();
        }
        else if (Integer.parseInt(tfnbjoueur.getText()) <= 2 ) {
            Alert al = new Alert(Alert.AlertType.WARNING);
            al.setTitle("Erreur de donnee");
            al.setContentText("Le nombre d'équipes doit être supérieur à 2 !");
            al.show();
        }

        else {
            Team t = new Team(tfnomteam.getText(),Integer.parseInt(tfnbjoueur.getText()), tfabout.getText(),tflogo.getText());
            ServiceTeam sp = new ServiceTeam();

            try {
               int rowsInserted  =sp.insertOneteam(t,g);
                if (rowsInserted > 0) {
                    Alert alert = new Alert(Alert.AlertType.INFORMATION);
                    alert.setTitle("Succès");
                    alert.setHeaderText("Team ajouté");
                    alert.setContentText("Le Team a été ajouté avec succès !");
                    alert.showAndWait();
                } else {
                    Alert alert = new Alert(Alert.AlertType.WARNING);
                    alert.setTitle("Attention");
                    alert.setHeaderText("Team existant");
                    alert.setContentText("Le team existe déjà !");
                    alert.showAndWait();
                }
                resetForm();
                data.clear();
                showteam();

            } catch (SQLException ex) {
                Alert al = new Alert(Alert.AlertType.ERROR);
                al.setTitle("Erreur de donnee");
                al.setContentText(ex.getMessage());
                al.show();
            }

        }
    }
    public void showteam() {
        try {
            List<Team> list = new ServiceTeam().selectoneteam(g);
            data.addAll(list);
        } catch (SQLException ex) {
            System.err.println(ex.getMessage());
        } catch (Exception ex) {
            ex.printStackTrace();
        }

        // Define the delete column and its cell factory
        TableColumn<Team, Void> deleteCol = new TableColumn<>("Delete");
        Callback<TableColumn<Team, Void>, TableCell<Team, Void>> deleteCellFactory = new Callback<TableColumn<Team, Void>, TableCell<Team, Void>>() {
            @Override
            public TableCell<Team, Void> call(final TableColumn<Team, Void> param) {
                final TableCell<Team, Void> cell = new TableCell<Team, Void>() {
                    private final Button deleteButton = new Button("Delete");

                    {
                        deleteButton.setOnAction((ActionEvent event) -> {
                            Team team = getTableView().getItems().get(getIndex());
                            try {
                                new ServiceTeam().deleteTeam(team.getNom_team());
                                data.remove(team);
                            } catch (SQLException ex) {
                                System.err.println(ex.getMessage());
                            }
                        });
                    }

                    @Override
                    protected void updateItem(Void item, boolean empty) {
                        super.updateItem(item, empty);
                        if (empty) {
                            setGraphic(null);
                        } else {
                            setGraphic(deleteButton);
                        }
                    }
                };
                return cell;
            }
        };


        // Check if the delete column is already present
        if (tableteam.getColumns().stream().noneMatch(col -> col.getText().equals("Delete"))) {
            deleteCol.setCellFactory(deleteCellFactory);
            tableteam.getColumns().add(deleteCol);
        }

        // Set the cell value factories for the other columns
        tnomteam.setCellValueFactory(new PropertyValueFactory<Team, String>("nom_team"));
        tnbjoueur.setCellValueFactory(new PropertyValueFactory<Team, Integer>("nb_joueurs"));
        tabout.setCellValueFactory(new PropertyValueFactory<Team, String>("about"));

        // Set the data for the table
        tableteam.setItems(data);
    }



    @FXML
    void updateteam(ActionEvent event) {
        Team teamselection = tableteam.getSelectionModel().getSelectedItem(); // récupère l'objet Groupe sélectionné dans le TableView

        Team tea = tableteam.getSelectionModel().getSelectedItem(); // récupère l'objet Groupe sélectionné dans le TableView

        Team t = new Team(tfnomteam.getText(), Integer.parseInt(tfnbjoueur.getText()), tfabout.getText(), tflogo.getText());
        ServiceTeam sp = new ServiceTeam();

        try {
            sp.updateteam(t, teamselection.getNom_team());

            resetForm();
            data.clear();
            showteam();
        } catch (SQLException ex) {
            Alert al = new Alert(Alert.AlertType.ERROR);
            al.setTitle("Erreur de donnee");
            al.setContentText(ex.getMessage());
            al.show();
        }
    }


    @FXML
    private void displayTeamStatistics(ActionEvent event) throws IOException {
        Team selectedTeam = tableteam.getSelectionModel().getSelectedItem();

        if (selectedTeam == null) {
            // No team is selected, show error message
            Alert alert = new Alert(Alert.AlertType.ERROR);
            alert.setTitle("Error");
            alert.setHeaderText(null);
            alert.setContentText("Please select a team to display its statistics.");
            alert.showAndWait();
            return;
        }

        // Create a 3D pie chart to display the team's statistics
        PieChart chart = new PieChartBuilder().width(800).height(600).title(selectedTeam.getNom_team() + " Statistics").build();
        chart.getStyler().setDefaultSeriesRenderStyle(PieSeries.PieSeriesRenderStyle.Donut);
        // Add data to the chart
        chart.addSeries("Wins", selectedTeam.getWin());
        chart.addSeries("Losses", selectedTeam.getLose());

        // Customize the chart
        chart.getStyler().setLegendPosition(LegendPosition.OutsideE);
        chart.getStyler().setPlotContentSize(0.9);
        chart.getStyler().setLegendVisible(true);
        chart.getStyler().setPlotContentSize(0.9);
        chart.getStyler().setAnnotationLineColor(Color.BLACK);

        SwingWrapper<PieChart> pieChartWrapper = new SwingWrapper<>(chart);


        // Create a new JDialog to hold the chart
        JPanel chartPanel = new XChartPanel<>(chart);

        // Display the chart
        JFrame frame = new JFrame(selectedTeam.getNom_team() + " Statistics");
        frame.setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);
        frame.add(chartPanel);
        frame.pack();
        frame.setVisible(true);
// Create a JButton
        JButton exportButton = new JButton("Export to PDF");

// Add an ActionListener to the button
        exportButton.addActionListener(e -> {
            // Create a Document object
            Document document = new Document();

            // Create a PdfWriter instance to write the document to a file or stream
            PdfWriter writer = null;
            try {
                writer = PdfWriter.getInstance(document, new FileOutputStream("C:\\Users\\bayou\\Desktop\\Nouveau dossier (2)\\chart.pdf"));

                // Open the document
                document.open();

                // Create a PdfContentByte instance from the PdfWriter
                PdfContentByte cb = writer.getDirectContent();

                // Create a Rectangle object to define the size of the PDF page
                // Set the size of the PDF page
                com.itextpdf.text.Rectangle pageSize = new com.itextpdf.text.Rectangle(200, 200);

                document.setPageSize(pageSize);

                // Create a PdfTemplate object to hold the contents of the JFrame
                PdfTemplate template = cb.createTemplate(frame.getWidth(), frame.getHeight());

                // Create a Graphics2D object from the PdfTemplate
                Graphics2D g2d = template.createGraphics(frame.getWidth(), frame.getHeight());

                // Draw the JFrame onto the Graphics2D object
                if (frame.isVisible()) {
                    frame.paint(g2d);
                }

                // Dispose of the Graphics2D object
                g2d.dispose();

                // Add the PdfTemplate to the document
                cb.addTemplate(template, 0, 0);

                JOptionPane.showMessageDialog(frame, "Exported to PDF successfully!");
            } catch (Exception ex) {
                ex.printStackTrace();
                JOptionPane.showMessageDialog(frame, "Error exporting to PDF.");
            } finally {
                if (writer != null) {
                    writer.close();
                }
                // Close the document
                document.close();
            }
        });



// Add the JButton to the JFrame
        frame.add(exportButton, BorderLayout.SOUTH);

     }
    public void btnretour(ActionEvent event) throws IOException {
        Parent root = FXMLLoader.load(getClass().getResource("adds.fxml"));

        Stage stage = (Stage) ((Node) event.getSource()).getScene().getWindow();
        Scene scene = new Scene(root);
        stage.setScene(scene);
        stage.show();

    }

    @FXML
    void uploadimageteam(MouseEvent event) throws IOException {
        FileChooser fileChooser = new FileChooser();
        fileChooser.setTitle("Choisir une image");
        fileChooser.getExtensionFilters().addAll(new FileChooser.ExtensionFilter("Image Files", "*.png", "*.jpg", "*.jpeg", "*.gif"));
        selectedImageFile = fileChooser.showOpenDialog(uploadt.getScene().getWindow());
        if (selectedImageFile != null) {
            Image image = new Image(selectedImageFile.toURI().toString());
            uploadt.setImage(image);

            // Générer un nom de fichier unique pour l'image
            String uniqueID = UUID.randomUUID().toString();
            String extension = selectedImageFile.getName().substring(selectedImageFile.getName().lastIndexOf(".")); // Récupérer
            // l'extension
            // de
            // l'image
            imageName = uniqueID + extension;

            // Enregistrer l'image dans le dossier "uploads"
            // Path destination = Paths.get("D:/SSD
            // SUPORT/Desktop/pidev_java/zeroWaste-javaFX/src/assets/ProductUploads/" +
            // imageName);
            Path destination = Paths.get("C:/Users/bayou/Desktop/WorkshopJDBC3A37/src/com/esprit/workshop/uploadtournoi/" + imageName);

            Files.copy(selectedImageFile.toPath(), destination, StandardCopyOption.REPLACE_EXISTING);
            tflogo.setText(imageName);
            // pour le controle de
            /*
            photoTest = 1;
            photoInputErrorHbox.setVisible(false);
             */
        }
    }
    private void resetForm() {
        tfnomteam.clear();
        tfnbjoueur.clear();
        tfabout.clear();
        tflogo.clear();
        imageteam.setImage(null);

        Image newImage = new Image("file:C:/Users/bayou/Desktop/WorkshopJDBC3A37/src/com/esprit/workshop/assets/download.png");
        imageteam.setImage(newImage);

    }

    public void clear() {
        resetForm();
    }
}
